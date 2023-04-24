run:
	docker compose up -d
	docker exec application composer install

test:
	docker exec application ./vendor/bin/pest

stop:
	docker compose down

destroy:
	docker compose down --rmi all --volumes