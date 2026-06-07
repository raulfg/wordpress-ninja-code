## Create directory for projects
mkdir ~/Sites
cd ~/Sites

## "park" the directory (all subdirectories will be sites)
valet park

## Create WordPress site
wp core download --path=my-site
cd my-site
wp config create --dbname=mysite --dbuser=root --dbpass=root
wp db create
wp core install --url=http://my-site.test --title="My Site" \
  --admin_user=admin --admin_password=secure_password --admin_email=admin@my-site.test

## Access http://my-site.test
