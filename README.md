# Poloniex MACD Hunter App

Try it online: https://poloniexmacdhunter.herokuapp.com/
____
This app look for all BTC pairs on Poloniex exchange and displays the status of the MACD indicator for all at once.

The status is composed of:
- **Histogram**: Shows positive if the MACD line is above de signal line, or negative if bellow.
- **Last Cross**: Shows how many hours the last crossing of the MACD line and signal line occurred, in 4 hour timeframe.
- **MACD above zero**: Shows whether the macd line is above zero. (yes/no)

## Running on local host

You will need a local PHP server, as well as a database management system(MySQL or PostgreSQL).<br>
Verify: https://www.apachefriends.org<br>
Install Composer Dependency Manager: https://getcomposer.org/<br>
Clone this repo to your localhost folder, and run: *composer install*<br>
Create a database named "poloniex" and configure the file connect_db (if running MySQL) or connect_db_pg(if running PostgreSQL) with the server info.<br>
On your browser open the admin.php file and press the button "check database" verify the connection. If connected successfully you are ready to proceed.

## Usage

On the admin page you have the options to create, drop, fill, update, and see the status of the tables.<br>
To start using the app you need to create the tables, fill them, and click the run button.<br>
To update the tables, just click the update button, and it will verify the last actualization and update the table in a 4h timeframe.<br>
By default the table start with 150 periods of 4h, and look only for BTC pairs.<br>
You can change this behaviour in the fill_table_coins and fill_table_data (MySQL database), or fill_table_coins_pg and fill_table_data_pg (PostgreSQL database).<br>
To automate the table update you can create a cron-job on your system.
