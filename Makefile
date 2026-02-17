# Variablen
DOCKER_COMPOSE_FILE := docker/docker-compose.yml
DOCKER_RUN = docker compose -f $(DOCKER_COMPOSE_FILE) run --rm
PHPUNIT = ./vendor/bin/phpunit
COMPOSER = $(DOCKER_RUN) app composer
TEST_DIR = tests
COVERAGE_DIR = coverage


# ----------------------------------------
# Hilfe anzeigen
.PHONY: help
help:
	@echo "Makefile für AuditClassGenerator"
	@echo ""
	@echo "Verfügbare Targets:"
	@echo "  install       - Baut den Container, installiert Dependencies, legt notwendige Ordner an"
	@echo "  uninstall     - Löscht alle generierten Ordner und Container (wie neu)"
	@echo "  test          - Führt alle Tests aus (ohne Xdebug)"
	@echo "  test-coverage - Führt alle Tests mit HTML-Coverage aus (mit Xdebug)"
	@echo "  test-select   - Führt gezielt bestimmte Tests aus (Option GROUP=groupname)"

# ----------------------------------------
# Install
.PHONY: install
install:
	docker compose -f $(DOCKER_COMPOSE_FILE) build --no-cache
	$(COMPOSER) install
	mkdir -p $(COVERAGE_DIR)
	mkdir -p $(TEST_DIR)

# ----------------------------------------
# Clean → Uninstall
.PHONY: uninstall
uninstall:
	docker compose -f $(DOCKER_COMPOSE_FILE) down -v --remove-orphans
	rm -rf $(COVERAGE_DIR)
	rm -rf vendor
	@echo "Alles aufgeräumt. Container, Volumes und Dependencies entfernt."

# ----------------------------------------
# Alle Tests ausführen (ohne Xdebug)
.PHONY: test
test:
	$(DOCKER_RUN) -e XDEBUG_MODE=off app $(PHPUNIT) --colors=always

# ----------------------------------------
# Tests mit Coverage (mit Xdebug)
.PHONY: test-coverage
test-coverage:
	$(DOCKER_RUN) -e XDEBUG_MODE=coverage app \
		$(PHPUNIT) --coverage-html $(COVERAGE_DIR) --colors=always

# ----------------------------------------
# Einzelne Testgruppen ausführen (ohne Xdebug)
.PHONY: test-select
test-select:
ifndef GROUP
	$(error Bitte GROUP=groupname angeben)
endif
	$(DOCKER_RUN) -e XDEBUG_MODE=off app \
		$(PHPUNIT) --group $(GROUP) --colors=always
