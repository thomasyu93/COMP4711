<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>title</title>
</head>
<body>
	<?php
	
	/**	Class for the TicTacToe game
	*
	*	Author: Thomas Yu
	*	Date : January 15, 2016
	*
	**/
	class Game {
		var $position;
		var $isWinner=false;
		var $noSpace=false;
		function __construct($squares){
			$this->position = str_split($squares);
		}
		/**	Function to determine if there is a winner on the board
		*	@param token: to character to check if there is a winner(x/o)
		*	Author: Thomas Yu
		*	Date : January 15, 2016
		*
		**/
		function winner($token){
			$result = false;	
			//Horizontal win check
			for($row = 0; $row < 3; $row ++) {
				$result = true;
				for($col = 0; $col < 3; $col ++) {
					if($this->position[3*$row + $col] != $token)
						$result = false;
				}
				if ($result == true)
					return $result;
			}
			//Vertical win check
			for($col = 0; $col < 3; $col ++) {
				$result = true;
				for($row = 0; $row < 3; $row ++) {
					if ($this->position [3 * $row + $col] != $token)
						$result = false;
				}
				if ($result == true)
					return $result;
			}
			// Diag 1 win check
			if (($this->position[2] == $token) && ($this->position[4] == $token) && ($this->position[6] == $token)) {
				$result = true;
				return $result;
			}
			//Diag 2 win check
			if (($this->position [0] == $token) && ($this->position [4] == $token) && ($this->position [8] == $token)){
				$result = true;
				return $result;
			}
			return $result;
		}
		/**	Function to display the board
		*	Author: Thomas Yu
		*	Date : January 15, 2016
		*
		**/
		function display(){
			echo '<h1 align="center">COMP 4711 LAB 1</h1>';
			$tied=$this->tieGame();
			if($this->isWinner || $tied ){
				$link = '?board='.'---------';
				echo '<div align="center"><a href="'.$link.'"><button class="button" align="center">Play Again?</button></a></div>';
				echo '</br>';
			}
			echo '<table cols="3" col width="130" align="center" style="font-size:large; font-weight:bold">';
			echo '<tr>';
			for ($pos=0; $pos<9; $pos++){
				echo $this->show_cell($pos);
				if ($pos%3 ==2)
					echo '</tr><tr>';	
			}
			echo '</tr>';
			echo '</table>';
		}
		/**	Function to place a token on the board
		*	Author: Thomas Yu
		*	Date : January 15, 2016
		*
		**/
		function show_cell($which){
			$token = $this->position[$which];
			if($token <> '-')
				return '<td>'.$token.'</td>';
			$this->newposition = $this->position;
			//On Click
			if($this->isWinner==false){
				$this->newposition[$which]= 'x';
				//Check if there is a slot avaliable for o and randomly place it on the board
				for($i=0; $i<9;$i++){
					if($this->newposition[$i]=='-'){
						while(1){
							$randPos=rand(0,8);
							if($this->newposition[$randPos]=='-' && $randPos!= $which){
								$this->newposition[$randPos]='o';
								break;
							}		
						}
						break;
					}
				}
			}
			$move = implode($this->newposition);
			$link = '?board='.$move;
			return '<td><a href="'.$link.'">-</a></td>';		
		}
		
		/**	Function to check if the board has avaliable slots
		*	Author: Thomas Yu
		*	Date : January 15, 2016
		*
		**/
		function tieGame(){
			for($i=0; $i<9;$i++){
				if($this->position[$i]=='-')
					return false;
			}
			return true;
		}
	}
	
	//Get the Xs,Os and -s in the board.
	$position = $_GET ['board'];
	$game1 = new Game($position);
	
	//Check if x won
	if ($game1->winner('x')){
		$game1->isWinner=true;
		echo '<h1 align="center">Congratulations, You Win!</h1>';
	//Check if o won
	} else if ($game1->winner('o')){
		$game1->isWinner=true;
		echo '<h1 align="center">O wins</h1>';
	} else //No winner
		echo '<h1 align="center">No Winner Yet</h1>';
	
	//Display the game
	$game1->display();
	?>
  </body>
</html>
