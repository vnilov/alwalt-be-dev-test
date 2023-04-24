# BE Developer Test Task

## Introduction
Since this is still a test task, not a production service, I allowed myself to make some assumptions, which I hope will not affect the final assessment of the work done.
Assumptions such as:
- Dockerfiles of the project are not optimized for production as well as `docker-compose.yml` file
- I didn't implement any cache layer
- I didn't implement any logging layer
- I didn't add DI like Symfony DI or PHP-DI
- I tried to keep the code and its structure as simple as possible

## Installation
In order to run the project, please follow the steps below:
1. Clone the repository
2. Run `make run`
3. Add the following line to your `/etc/hosts` file: `127.0.0.1 image.anwalt.local`, this is necessary to access the project because this hostname I added to the Nginx config
4. That's all. You can access the project by the following URL: `http://image.anwalt.local:8080` -  you should see the Nginx welcome page

## Usage
The project has only one endpoint: `http://image.anwalt.local:8080/{filename}/` which accepts only `GET` requests with at least modifier parameter
Currently, there are only two modifiers available:
- crop, defined with width and height parameters
- resize, also defined with width and height parameters

By default, project has only two images:
- 1.jpg
- 2.jpg

Here are some examples of how to use the endpoint:
- `http://image.anwalt.local:8080/1.jpg/?crop=100,100` - this will crop the image to 100x100px
- `http://image.anwalt.local:8080/1.jpg/?resize=100,100` - this will resize the image to 100x100px

You can also combine modifiers, for example:
- `http://image.anwalt.local:8080/1.jpg/?crop=100,100&resize=200,200` - this will crop the image to 100x100px and then resize it to 200x200px, so **the order of modifiers matters**

## Testing
In order to run automated tests, please run the following command: `make test`

## Removing the project
The project is running in Docker containers with the Volumes which will not be removed after you remove the containers, so in order to remove it, please run the following command: `make destroy`

## Additional information
Please, if you have any questions, don't hesitate to contact me via email: `nilov.vadim@proton.me` or via Telegram: `@vadisyon`. 
We can also schedule a call if you want to discuss something.