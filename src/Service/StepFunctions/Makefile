.EXPORT_ALL_VARIABLES:

initialize: start-docker
start-docker:
	# TODO use the global container (adding the port in it) once it is updated
	# docker start async_aws_localstack && exit 0 || \
	docker start async_aws_localstack-stepfunctions && exit 0 || \
	docker pull localstack/localstack:2.3.2 && \
	docker run -d -p 4580:4566 -e SERVICES=stepfunctions -v /var/run/docker.sock:/var/run/docker.sock --name async_aws_localstack-stepfunctions localstack/localstack:2.3.2 && \
	docker run --rm --link async_aws_localstack-stepfunctions:localstack martin/wait -c localstack:4566

test: initialize
	./vendor/bin/simple-phpunit

clean: stop-docker
stop-docker:
	docker stop async_aws_localstack-stepfunctions || true
	docker rm async_aws_localstack-stepfunctions || true
