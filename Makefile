DB := pinet_cms_dev

fake: migrate
	./vendor/bin/clips fake

test:
	@phpunit

c:
	@mysql -u root "${DB}"
