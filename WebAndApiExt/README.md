Extension App Webpage

# An example template for releasing extensions across all platforms. For this app we show how to build a simple browser history plugin

#technology used :
1 frontend : html 5 and css
2 backend : Laravel 8.0
3 Database : Firebase cloud

Details : 
It will track all the browsing history of users and save it to firebase realtime cloud database

Instructions :
Please fill below given data for your firebase integration to work in your env file.
TYPE=
PROJECT_ID=
PRIVATE_KEY_ID=
PRIVATE_KEY=
CLIENT_EMAIL=
CLIENT_ID=
AUTH_URI=
TOKEN_URI=
AUTH_PROVIDER_x509_CERT_URL=
CLIENT_x509_CERT_URL=
DATABASE_URI=

Commands to run after cloning : 
1 php artisan optimize:clear
2 php artisan key:generate
3 composer install
4 npm install

Tests :
1 URL Testing
2 Load Testing
3 Security Testing