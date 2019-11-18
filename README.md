# aukcje

git clone git@github.com:maruleq/aukcje.git

cd aukcje

composer install

php bin/console doctrine:migrations:migrate

php bin/console server:run
