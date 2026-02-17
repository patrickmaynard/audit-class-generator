# Variablen
DOCKER_COMPOSE_FILE := docker/docker-compose.yml
PHPUNIT=docker compose -f $(DOCKER_COMPOSE_FILE) run --rm app ./vendor/bin/phpunit
COMPOSER=docker compose -f $(DOCKER_COMPOSE_FILE) run --rm app composer
TEST_DIR=tests
COVERAGE_DIR=coverage


# ----------------------------------------
# Hilfe anzeigen
.PHONY: help
help:
	@echo "Makefile für AuditClassGenerator"
	@echo ""
	@echo "Verfügbare Targets:"
	@echo "  install       - Baut den Container, installiert Dependencies, legt notwendige Ordner an"
	@echo "  uninstall     - Löscht alle generierten Ordner und Container (wie neu)"
	@echo "  test          - Führt alle Tests aus"
	@echo "  test-coverage - Führt alle Tests mit HTML-Coverage aus"
	@echo "  test-select   - Führt gezielt bestimmte Tests aus (Option TEST=Pfad/zum/Test)"

# ----------------------------------------
# Install: Container bauen, Dependencies installieren, Ordner anlegen
.PHONY: install
install:
	docker compose -f $(DOCKER_COMPOSE_FILE) build --no-cache
	$(COMPOSER) install
	mkdir -p $(COVERAGE_DIR)
	mkdir -p $(TEST_DIR)

# ----------------------------------------
# Clean → Uninstall: alles entfernen wie vorher
.PHONY: uninstall
uninstall:
	docker compose -f $(DOCKER_COMPOSE_FILE) down -v --remove-orphans
	rm -rf $(COVERAGE_DIR)
	rm -rf vendor
	@echo "Alles aufgeräumt. Container, Volumes und Dependencies entfernt."

# ----------------------------------------
# Alle Tests ausführen
.PHONY: test
test:
	$(PHPUNIT) --colors=always

# ----------------------------------------
# Tests mit Coverage
.PHONY: test-coverage
test-coverage:
	$(PHPUNIT) --coverage-html $(COVERAGE_DIR) --colors=always

# ----------------------------------------
# Einzelne Tests / Gruppen ausführen: GROUP=groupname
.PHONY: test-select
test-select:
ifndef GROUP
	$(error Bitte GROUP=groupname angeben)
endif
	$(PHPUNIT) --group $(GROUP) --colors=always
