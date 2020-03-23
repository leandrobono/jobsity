Installation:

-Clone git repository:
    git clone git@github.com:leandrobono/jobsity.git

-Get into directory
    cd jobsity

-Create Docker image:
    ./build.sh 1.0.0

-Start docker-compose:
    docker-compose up -d

-Install dependencies
    docker exec -ti jobsity_api_1 bash
    cd /var/www/html/
    composer install
    exit

-Get into mysql container and run db script:
    docker exec -ti mysqljobsity bash
    mysql -u root

    once logged into mysql:
        use jobsity;
        source db.sql;
        exit
    
    exit

-Get into the application:
    http://localhost:8080/web

-Available commands:
    Create user: /user username password currency
        Example: /user leandro mypass ARS
    
    Log in: /login username password
        Example: /login leandro mypass
    
    Deposit money: /transaction deposit amount
        Example: /transaction deposit 150

    Deposit money with money conversion: /transaction deposit amount fromCurrency
        Example: /transaction deposit 150 USD
        150USD will be convert to user actual currency and deposit on account
    
    Withdraw money: /transaction withdraw amount
        Example: /transaction withdraw 50

    Withdraw money with money conversion: /transaction withdraw amount fromCurrency
        Example: /transaction withdraw 50 USD
        50USD will be convert to user actual currency and withdraw from account
    
    Account balance: /balance

    Conversion: /convert fromCurrency toCurrency amount
        Example: /convert ARS USD 20