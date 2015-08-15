DB := mam

fake: migrate
	./vendor/bin/clips fake

migrate:
	@mysql -u root -e "use ${DB}"
	@./vendor/bin/clips phinx migrate

epg:
	@mysql -u root -e "use ${DB};drop table if exists phinxlog;drop table if exists play_histories;drop table if exists devices;drop table if exists search_keys;"

clean: epg migrate
	@echo Clean epg tables and rebuild;

test:
	@phpunit

c:
	@mysql -u root "${DB}"
init:
	./vendor/bin/clips init

.PHONY: init c test clean epg migrate fake
