## LEMP SERVER WITH SELF SIGNED CERTIFICATE

A Simple 3 Tier application server running PHP-7-FPM, NGINX and MYSQL with dummy dataset created on build with docker-composer

### Prerequisites

Deployment puts into consideration that a VM is runnig the latest verions of docker, docker-compose and git

For information on setting up a docker environment on any platform visit; [LEMP-ssl](https://github.com/adekoyadapo/LEMP-ssl.git)

Also [Docker Install](https://docs.docker.com/install/) for various distro installation

For this build it will be setup on a Google Compute Engine with a start up script deploying and fetching the repository

This install assumes you have a running VM in which ever environment with all requirements installed.

For standalone environments like running in on a local machine with temporary certificates visit

### Requirement for GCP environment

Dependencies includes Git Wget docker docker-compose
Ensure selinux is set to disabled or permissive
The startup script below will ensure dependencies are met for a Centos 7 VM and the repository is pulled and installed in a specified home directory

You have an already verified domain name with access to nameserver records and create A records and cname and PTR record for the IP given.

Visit [Google WebMAster](https://www.google.com/webmasters/verification/home) for information on the verification process. The best process might be to use a TXT record setup in CloudDNS

As this install is for GCP, when creating a VM ensure you enable PTR on the nic

Visit [GCP PTR Record](https://cloud.google.com/compute/docs/instances/create-ptr-record)


For Centos 7 VM Start-up script can be
```
#/bin/bash
yum clean all && yum update -y && yum install docker git wget bind-utils -y
sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose
sudo sed -i 's/enforcing/disabled/g' /etc/selinux/config /etc/selinux/config
sudo setenforce 0
chkconfig docker on
service docker start
mkdir -p /home/LEMP && cd /home/LEMP
git clone https://github.com/adekoyadapo/lemp-ssl-secure.git
reboot now
```
You can remove the reboot line incase you want to get right into it.

### Setup and deploy

SSH into the machine using the cloud shell by clicking on the SSH by the instance IP and copying the cloudshell command or start in cloudshell

```
gcloud compute --project "project-name" ssh --zone "zone" "instance-name"
```
Ensure you become root and change directory to the downloaded folder

```
sudo -s && cd /home/LEMP/lemp-ssl-secure
```
Incase the folder is not avalable run the command below

```
git clone https://github.com/adekoyadapo/lemp-ssl-secure.git
```

You will need to edit the init file and or the nginx default.conf file
First the certificate request script. "init-lemp-ssl.sh"
Edit and change the domains and email section, you might want to set the staging to 1 for test purposes to avoid request limits and re-run the script again to ensure it gets a certificate. Enter y/n when prompted for recieve further information
Next edit the default.conf file and change the server_name in the file from localhost to your registered and verified domain name and also the certificate path "/etc/letsencrypt/live/<demo.domain>/privkey.pem" replacing <demo.domain> with the domain name entered in the init-lemp-ssl.sh file

Run the initial build for all containers

```
docker-compose up -d 
```

Then run the script to initialize the build
```
./init-ssl-secure.sh
```
## SSL Deployment

Simply run the command below to update the ssl files into the nginx webserver config
```
docker-compose up -d --build
```

## Built With

* [Docker](https://www.docker.com/) - Enterprise Container Platform
* [Docker Compose](https://docs.docker.com/compose/) - Multi-Container deployment
* [Centos 7](https://www.centos.org/about/) - Linux RHEL Distro
* [PHP-FPM 7](https://php-fpm.org/) - FastCGI Processor
* [MySQL](https://www.mysql.com/) - SQL database
* [Nginx](https://www.nginx.com/resources/glossary/nginx/) - Multipurpose WebServer
* [Certbot](https://certbot.eff.org/) - HTTPS automated deployment with letsencrypt


## Authors

* **Ade** - *First Repo* - [ADEADEKOYA](https://github.com/adekoyadapo)

## Resource

* [Letsencrypt](https://letsencrypt.org/docs/certificates-for-localhost/) - Free Site SSL
* [Medium](https://medium.com/@pentacent/nginx-and-lets-encrypt-with-docker-in-less-than-5-minutes-b4b8a60d3a71) - Nginx and Let’s Encrypt with Docker in Less Than 5 Minutes
* [Miroslav Shubernetskiy](https://miki725.com/docker/crypto/2017/01/29/docker+nginx+letsencrypt.html) - Docker + Nginx + LetsEncrypt
* [Digital Ocean](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-ubuntu-18-04) - How To Install Linux, Nginx, MySQL, PHP (LEMP stack) on Ubuntu 18.04
