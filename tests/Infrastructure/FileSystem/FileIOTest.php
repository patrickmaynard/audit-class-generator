<?php
declare(strict_types=1);

namespace PatrickMaynard\AuditClassGenerator\Tests\Infrastructure\FileSystem;

use org\bovigo\vfs\vfsStreamDirectory;
use PatrickMaynard\AuditClassGenerator\Infrastructure\Exception\EmptyFileException;
use PatrickMaynard\AuditClassGenerator\Infrastructure\Exception\FileDoesNotExistException;
use PatrickMaynard\AuditClassGenerator\Infrastructure\Exception\FileNotWritableException;
use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use PatrickMaynard\AuditClassGenerator\Infrastructure\FileSystem\FileIO;

class FileIOTest extends TestCase
{
    private vfsStreamDirectory $root;

    protected function setUp(): void
    {
        // Erstelle ein virtuelles Dateisystem (vfsStream)
        $this->root = vfsStream::setup('root'); // Wurzelverzeichnis erstellen
    }

    public function testReadFileDoesNotExist(): void
    {
        $path = vfsStream::url('root/nonexistentfile.txt');

        $fileIO = new FileIO();

        $this->expectException(FileDoesNotExistException::class);
        $this->expectExceptionMessage('File does not exist: ' . $path);

        $fileIO->read($path);
    }

    public function testReadFileIsEmpty(): void
    {
        $path = vfsStream::url('root/emptyfile.txt');

        vfsStream::newFile('emptyfile.txt')->at($this->root); // Leere Datei erstellen

        $fileIO = new FileIO();

        $this->expectException(EmptyFileException::class);
        $this->expectExceptionMessage('File is empty: ' . $path);

        $fileIO->read($path);
    }

    public function testReadFileWithBomIsEmpty(): void
    {
        vfsStream::newFile('emptyfile.txt')->withContent("\xEF\xBB\xBF")->at($this->root); // Leere Datei mit BOM erstellen

        $fileIO = new FileIO();
        $this->expectException(\RuntimeException::class);
        $fileIO->read(vfsStream::url('root/emptyfile.txt'));
    }

    public function testReadFileContainsTwigContent(): void
    {
        $content = 'Hello, {{ name }}!';
        vfsStream::newFile('twigfile.txt')->withContent($content)->at($this->root);

        $fileIO = new FileIO();
        $result = $fileIO->read(vfsStream::url('root/twigfile.txt'));

        $this->assertEquals($content, $result);
    }

    public function testWriteFileDoesNotExist(): void
    {
        $path = vfsStream::url('root/nonexistingdir/newfile.txt');

        $fileIO = new FileIO();

        $this->expectException(FileDoesNotExistException::class);
        $this->expectExceptionMessage('File does not exist: ' . $path);

        $fileIO->write($path, 'Test content');
    }

    public function testWriteFileExistsAndIsOverwritten(): void
    {
        $path = vfsStream::url('root/existingfile.txt');

        vfsStream::newFile('existingfile.txt')->withContent('Old content')->at($this->root);

        $fileIO = new FileIO();
        $fileIO->write($path, 'New content');

        $content = file_get_contents($path);
        $this->assertEquals('New content', $content);
    }

    public function testWriteFileWithoutWritePermissions(): void
    {
        $path = vfsStream::url('root/readonlyfile.txt');

        vfsStream::newFile('readonlyfile.txt')
            ->chmod(0444)
            ->at($this->root);

        $fileIO = new FileIO();

        $this->expectException(FileNotWritableException::class);
        $this->expectExceptionMessage('File not writable: ' . $path);

        $fileIO->write($path, 'Test content');
    }
}
