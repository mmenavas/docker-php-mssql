## CentOS Docker Images for PHP-MSSQL Projects 
This repo provides everything you need to build a docker-powered local environment for PHP and MSSQL development.

**Note:** You do not need to clone this repo. Zipped files are provided for each environment type (e.g. CentOS 7 and PHP 7.0).

### Requirements
- Install [Docker for Mac](https://www.docker.com/docker-mac).
- Install [Ahoy!](http://www.ahoycli.com/en/latest/).

### Instructions:
- Navigate to the CentOS directory that makes sense for your project.
- Navigate to the PHP directory that makes sense for your project.
- Download zip file and uncompress on the directory that you wish to 'dockerize'.
- Run `ahoy up` to start your local dev environment.
- Run `ahoy --help` to get a list of available commands.

### How does it work?
Uncompressing the zip file creates the following directory structure:
```
.
├── .ahoy.yml
├── .docker
│   ├── Dockerfile
│   ├── apache
│   │   ├── ssl.conf
│   │   └── v-host.conf
│   ├── mssql
│   │   └── odbcinst.ini
│   ├── php
│   │   ├── dev.ini
│   │   ├── timezone.ini
│   │   └── xdebug.ini
│   └── scripts
│       └── start.sh
└── docker-compose.yml
```

`.docker/Dockerfile` uses an official CentOS image as a base. Then the following extensions and packages are added:
- PHP
- PHP extension nedded to connect to MSSQL servers.
- Composer
- Drush 8.x (for drupal development)
- Apache

`docker-compose.yml` sets up the apache a mysql containers.

`ahoy.yml` provides a list of basic commands commonly used by developers. See the list of commands below:
```
$ ahoy --help
NAME:
   ahoy - Creates a configurable cli app for running commands.
USAGE:
   ahoy [global options] command [command options] [arguments...]
   
COMMANDS:
   build	Build or rebuild webserver image.
   down		Stop and remove all containers, volumes, and networks.
   drush	Run a command in the apache container. The command that follows `ahoy run` must be wrapped in quotes. `ahoy run 'php --version'`
   mysql	Connect to the default mysql database.
   mysql-dump	Dump data out into a file. `ahoy mysql-import > backups/local.sql`
   mysql-import	Pipe in a sql file.  `ahoy mysql-import < backups/live.sql`
   ps		List all running containers.
   restart	Restart the containers.
   run		Run a command in the apache container. The command that follows `ahoy run` must be wrapped in quotes. `ahoy run 'php --version'`
   ssh		Connect to apache container via ssh.
   stop		Stop the containers (non-destructive).
   up		Start the containers.
   init		Initialize a new .ahoy.yml config file in the current directory.

GLOBAL OPTIONS:
   --verbose, -v		Output extra details like the commands to be run. [$AHOY_VERBOSE]
   --file, -f 			Use a specific ahoy file.
   --help, -h			show help
   --version			print the version
   --generate-bash-completion	
   
VERSION:
   2.0.0
```

### Extras
#### MSSQL Server
If you'd like run a MSSQL server locally, swap the contents of the docker-compose file
that came in the zip file with the contets of the docker-compose file in the `extras` directory.