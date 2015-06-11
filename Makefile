DB := mam

fake: migrate
	./vendor/bin/clips fake

migrate:
	@mysql -u root -e "use ${DB}"
	@./vendor/bin/clips phinx migrate

epg:
	@mysql -u root -e "use ${DB};drop table if exists phinxlog;drop table if exists play_histories;drop table if exists devices;drop table if exists recommend_titles;drop table if exists search_keys;UPDATE title_application SET actors = TRIM(REPLACE(actors, ' , ', ','));"

clean: epg migrate
	@echo Clean epg tables and rebuild;

actors:
	@mysql -u root -e "use ${DB};UPDATE title_application SET actors = TRIM(REPLACE(actors, ' , ', ','));"

test:
	@phpunit

c:
	@mysql -u root "${DB}"
