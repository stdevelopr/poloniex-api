<!DOCTYPE html>
<html class="bg-dark text-light" lang="pt-br">
    <head>
        <title>Poloniex MACD</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/main.css">
        <link rel="shortcut icon" href="/favicon.ico">

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
    </head>

    <body class="bg-dark text-light">

		<!-- check database -->
		<div class="container bg-danger rounded border border-danger text-center">
			<input type="button" value="Check Database" class="btn btn-danger btn-outline-dark mx-auto d-block" onclick="connect()">
			<div class="container border border-danger rounded text-left col-sm-2">
				<div class="form-check">
				  <input class="form-check-input" id= "mysql" type="radio" name="database" value="MySQL" checked>
				  <label class="form-check-label" for="exampleRadios1">
				    MySQL
				  </label>
				</div>

				<div class="form-check">
				  <input class="form-check-input" id = "postgre" type="radio" name="database" value="PostgreSQL">
				  <label class="form-check-label" for="exampleRadios1">
				    PostgreSQL
				  </label>
				</div>
			</div>
			<p id="result"> Connection... </p>
		</div>

		<!-- check tables -->
		<div class="container  mt-3">
			<div class="row">
				<div class="container col-sm-4 text-center">
					<div class="container">		
						<input type="button" value="Check Coins table" class="btn btn-warning" onclick="check_table_coins()">	
						<p id="table_coins_status"> Table status...</p>
					</div>
					<div class="container">				
						<input type="button" value="Check Data table" class="btn btn-warning" onclick="check_table_data()">		
						<p id="table_data_status"> Table status...</p>			
					</div>
				</div>
			
				<!-- create tables -->
				<div class="container col-sm-4 d-inline-block text-center">
					<div class="container d-inline-block">	
						<input type="button" value="Create Coins table"  class="btn btn-secondary" onclick="create_table_coins()">
						<p id="create_coins_status"> ?</p>
					</div>
					<div class="container">	
						<input type="button" value="Create Data table" class="btn btn-secondary" onclick="create_table_data()">
						<p id="create_data_status"> ?</p>
					</div>
				</div>
				
				<!-- drop tables -->
				<div class="container col-sm-4 d-inline-block text-center">
					<div class="container d-inline-block">	
						<input type="button" class="btn btn-dark btn-outline-danger" value="Drop Coins table" onclick="drop_table_coins()">
						<p id="drop_coins_status">.</p>
					</div>
					<div class="container">	
						<input type="button" class="btn btn-dark btn-outline-danger" value="Drop Data table" onclick="drop_table_data()">
						<p id="drop_data_status">.</p>
					</div>
				</div>
			</div>
		</div>
		
		<!-- fill tables -->
		<div class="container mt-3 text-center">
			<div class="container">
				<input type="button" class="btn btn-primary m-3" value="Fill Coins table" onclick="fill_table_coins()">	
				<p id="fill_coins_status"></p>
		
				<input type="button"  class="btn btn-primary m-3" value="Fill Data table" onclick="fill_table_data()">		
				<p id="fill_data_status"></p>

			</div>
		</div>		

		<!--tables info-->
		<div class="container mt-3 text-center">
			<div class="container">
				<input type="button" class="btn btn-info m-3" value="Data status" onclick="data_status()">	
				<p id="data_status"></p>

				<input type="button" class="btn btn-info m-3" value="Data atualize" onclick="data_atualize()">
				<p id="data_atualize"></p>
			</div>
		</div>
		
		<!-- run aplicattion -->
		<div class="container text-center mt-5">		
			<input type="button" class="btn btn-success" value="RUN" onclick="run()">
		</div>

		<script src="js/script.js"></script>
    </body>
</html>