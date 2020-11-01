composer-install:
	@docker run \
		--rm \
		--interactive \
		--tty \
		--volume $(shell pwd):/code \
		--workdir /code \
		composer install

test:
	@docker run \
		--rm \
		--interactive \
		--tty \
		--volume $(shell pwd):/code \
		--workdir /code \
		composer test

lint:
	@docker run \
		--rm \
		--interactive \
		--tty \
		--volume $(shell pwd):/code \
		--workdir /code \
		composer check-style

lint-fix:
	@docker run \
		--rm \
		--interactive \
		--tty \
		--volume $(shell pwd):/code \
		--workdir /code \
		composer fix-style
