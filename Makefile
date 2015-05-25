DB := mam

fake: migrate
	./vendor/bin/clips fake

migrate:
	@mysql -u root -e "use ${DB}"
	@./vendor/bin/clips phinx migrate

test:
	@phpunit

c:
	@mysql -u root "${DB}"
