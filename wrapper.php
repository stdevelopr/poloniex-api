<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Ajax com PHP</title>
        <meta charset="utf-8">
    </head>
    <body>
		<!-- check database -->
		<input type="button" value="Check Database" onclick="connect()">
		<input id= "mysql" type="radio" name="database" value="MySQL" checked> MySQL
		<input id = "postgre" type="radio" name="database" value="PostgreSQL"> PostgreSQL
		<p id="result"> Connection... </p>

		<!-- check tables -->
		<div>	
			<input type="button" value="Check Coins table" onclick="check_table_coins()">
		</div>
		<p id="table_coins_status"> Table status...</p>

		<div>	
			<input type="button" value="Check Data table" onclick="check_table_data()">
		</div>
		<p id="table_data_status"> Table status...</p>


		<div>	
			<input type="button" value="Create Coins table" onclick="create_table_coins()">
		</div>
		<p id="create_coins_status"> Create table Coins</p>

		<div>	
			<input type="button" value="Create Data table" onclick="create_table_data()">
		</div>
		<p id="create_data_status"> Create table Data</p>


		<div>	
			<input type="button" value="Fill Coins table" onclick="fill_table_coins()">
		</div>
		<p id="fill_coins_status"> Fill table Coins</p>

		<div>	
			<input type="button" value="Fill Data table" onclick="fill_table_data()">
		</div>
		<p id="fill_data_status"> Fill table Data</p>

		<div>	
			<input type="button" value="Drop Coins table" onclick="drop_table_coins()">
		</div>
		<p id="drop_coins_status"> Drop table Coins</p>

		<div>	
			<input type="button" value="Drop Data table" onclick="drop_table_data()">
		</div>
		<p id="drop_data_status"> Drop table Data</p>


		<div>	
			<input type="button" value="Data status" onclick="data_status()">
		</div>
		<p id="data_status"> Data status</p>


		<div>	
			<input type="button" value="Data atualize" onclick="data_atualize()">
		</div>
		<p id="data_atualize"> Data Atualize </p>




		<script src="js/script.js"></script>
    </body>
</html>