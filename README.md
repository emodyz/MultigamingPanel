<p align="center">
    <a href="https://ezgames.fr" target="_blank">
        <img src="https://flashmodz.fr/img/33844530.png" width="150">
    </a>
</p>
<p align="center">
    <img src="https://github.com/emodyz/MultigamingPanel/workflows/Emodyz%20v6/badge.svg">
</p>

## What does this project offer ?

After long months of waiting,
here is a new version of the previously proposed launcher.
This version is an Alpha whose only goal is to analyze the operation and improve it for the next official version.

Here are the features included right out of the box :

- [x] Compatibility with Arma3 (will evolve with updates)
- [x] Users management
- [x] Possibility of multiple Mod Pack
- [x] Automatic multi-thread
- [x] New technology (Web interface and Launcher)

Several other features will be added over time

## How to install this project?

You can easily install the necessary components by following the steps below.

###### Step 1 Clone the repository
```console
foo@bar:~$ git clone https://github.com/emodyz/MultigamingPanel.git && cd MultigamingPanel/
```

###### Step 2 Install Composer, NodeJS & NPM
The relevant instructions for your Operating System are available here: https://getcomposer.org/download/ and here: https://nodejs.org/en/download/                                  

###### Step 3 Install the relevant dependencies
```console
foo@bar:~/MultigamingPanel$ composer install && npm install
```

###### Step 4 Configure your installation
```console
foo@bar:~/MultigamingPanel$ cp .env.example .env && nano .env
```

###### Step 5 Compile the client-side assets & initilize your database
```console
foo@bar:~/MultigamingPanel$ npm run prod && php artisan migrate
```

###### Step 6 Configure your webserver to point to the public/ sub-directory

###### Step 6 Open the required ports
```console
foo@bar:~/MultigamingPanel$ ufw allow 443
foo@bar:~/MultigamingPanel$ ufw allow 6001
foo@bar:~/MultigamingPanel$ ufw allow 6660
```

## Emodyz Sponsors

You can sponsor us through various means. 

In particular, we offer managed hosting spaces for you. 
Our objective is twofold, 
we want to facilitate your technical "server" management and guarantee you the performance required for our products.
It also helps us to finance the various tools we use in order to provide you with more and more features.
