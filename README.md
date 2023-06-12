#  Currency exchange application

The application is integrated with the NBP bank. You can see list of currencies with details.
If List is empty you must click update button. 
Additional function is possibility to converse pasted amount in chosen currency.

To start press "Update table" button.

## Requirements

Make sure you have the latest versions of **Docker** and **Docker Compose** installed on your machine.

Clone this repository or copy the files from this repository into a new folder. In the **docker-compose.yml** file you may change the IP address (in case you run multiple containers) or the database from MySQL to MariaDB.

## Configuration

Edit the `.env` file to change the default IP address, MySQL root password and Database name.

## Installation

Open a terminal and `cd` to the folder in which `docker-compose.yml` is saved and run:

```
docker-compose up --build -d
```

This creates two new folders next to your `docker-compose.yml` file.

* `data` – used to store and restore database dumps and initial database for import
* `web` – the location of your php application files

The containers are now built and running. You should be able to access the WordPress installation with the configured IP in the browser address. By default, it is `http://127.0.0.1`.

For convenience, you may add a new entry into your hosts file.

## Usage

### Starting containers

You can start the containers with the `up` command in daemon mode (by adding `-d` as an argument) or by using the `start` command:

```
docker-compose start
```

### Stopping containers

```
docker-compose stop
```

### Removing containers

To stop and remove all the containers use the`down` command:

```
docker-compose down
```

Use `-v` if you need to remove the database volume which is used to persist the database:

```
docker-compose down -v
```


### phpMyAdmin

You can also visit `http://127.0.0.1:8000` to access phpMyAdmin after starting the containers.

The default username is `root`, and the password is the same as supplied in the `.env` file.

### Used technology

To create this application I used 

php version 8.1

mysql latest

nginx latest