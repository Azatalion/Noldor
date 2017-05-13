<!DOCTYPE html>
<html>
	<head>
		<title>Лабораторная работа №2</title>
		<link type="text/css" rel="stylesheet" href="style.css">
	</head>
	<body>
		<h1>Тип ввода: матрица n*n</h1>
		<form method = "post" action = "index.php">
			<div>
				<textarea name = "attitude" type = "text" rows = "9"><?=$_POST['attitude']?></textarea>
			</div>
			<input type = "submit" value = "Определить свойства">
		</form>
		<?php
			$good = 0;
			$m = 1;
			$n = 1;
			$attitude = explode(" ", $_POST['attitude']);
			if ($_POST['attitude'] != "") {
				findTrue($attitude);
				$attitude = beGood($attitude);
				validation($attitude);
				if ($good > 0) {
					write($attitude);
					$trans = transposed($attitude);
					$anti = forAnti($attitude, $trans);
					echo "<br>Данное отношение:";
					reflexivity($attitude);
					symmetry($attitude, $trans);
					antisymmetry($anti);
					transitivity($attitude, $anti);
				}
			}
			else {
				echo "<p>Введите матрицу</p>";
			}
			
			function findTrue($a) {
				global $m, $n;
				for ($i = 0; $i < count($a); $i++) {
					if (strlen($a[$i]) <= 1) {
						$m++;
					}
					else {
						$i =  count($a);
					}
				}
				for ($i = 0; $i < count($a); $i++) {
					if (strlen($a[$i]) > 1) {
						$n++;
					}
				}
				if ($n == 1) {
					$m--;
				}
				return $m; return $n;
			}
			
			function beGood($a) {
				$k = 0;
				$may = 0;
				global $m, $n;
				for ($i = 0; $i < $n; $i++) {
					echo "<br>";
					for ($j = 0; $j < $m; $j++) {
						if (strlen ($a[$k]) == 1) {
							$arr[$i][$j] = $a[$k];
						}
						if (strlen ($a[$k]) > 1) {
							$at = $a[$k];
							$l = 0;
							while (is_numeric($at[$l])) {
								$arr[$i][$j] = $arr[$i][$j].$at[$l];
								$l++;
							}
							$may++;
						}
						if ($may >= 1) {
							if (strlen ($a[$k - 1]) > 1) {
								$at = $a[$k - 1];
								$arr[$i][$j] = "";
								for ($l = 3; $l < strlen($at); $l++) {
									$arr[$i][$j] = $arr[$i][$j].$at[$l];
								}
								$may--;
								$k--;
							}
						}
						$k++;
					}
				}
				return $arr;
			}
			
			function validation($a) {
				global $m, $n, $good;
				$good++;
				if ($m != $n) {
					echo "<p>Количество столбцов (".$m.") не равно количеству строк (".$n.")</p>";
				}
				for ($i = 0; $i < $n; $i++) {
					for ($j = 0; $j < $m; $j++) {
						if ($a[$i][$j] == "") {
							echo "<p>Не введён элемент ".$j."-го столбца ".$i."-ой(ей) строки</p>";
							$good--;
						}
						if ($a[$i][$j] != 1 && $a[$i][$j] != 0 || !is_numeric($a[$i][$j])) {
							echo "<p>Некорректный элемент ".$j."-го столбца ".$i."-ой(ей) строки</p>";
							$good--;
						}
					}
				}
				return $good;
			}
	
			function write ($a) {
				echo "Матрица отношения [R]:";
				global $n;
				for ($i = 0; $i < $n; $i++) {
					echo "<br>";
					for ($j = 0; $j < $n; $j++) {
						echo " ".$a[$i][$j];
					}
				}
			}
			
			function reflexivity ($a) {
				global $n;
				$good = 1;
				for ($i = 0; $i < $n; $i++) {
					for ($j = 0; $j < $n; $j++) {
						if ($a[$i][$i] != 1) {
							$good--;
						}
						
					}
				}
				if ($good != 1) {
					echo "<br>Не рефлексивно";
				}
				else {
					echo "<br>Рефлексивно";
				}
			}
			
			function transposed ($a) {
				global $n;
				echo "<br>Транспонированная матрица [R]<sup>T</sup>:"; 
				for ($i = 0; $i < $n; $i++) {
					echo "<br>";
					for ($j = 0; $j < $n; $j++) {
						$arr[$i][$j] = $a[$j][$i];
						echo " ".$arr[$i][$j];
					}
				}
				return $arr;
			}
			
			function symmetry ($a, $b) {
				global $n;
				$good = 1;
				for ($i = 0; $i < $n; $i++) {
					for ($j = 0; $j < $n; $j++) {
						if ($a[$i][$j] != $b[$i][$j]) {
							$good--;
						}
					}
				}
				if ($good != 1) {
					echo "<br>Не симметрично";
				}
				else {
					echo "<br>Симметрично";
				}
			}
			
			function forAnti ($a, $b) {
				global $n;
				echo "<br>Матрица, умноженная на транспонированную [R]*[R]<sup>T</sup>:";
				for ($i = 0; $i < $n; $i++) {
					for ($j = 0; $j < $n; $j++) {
						for ($l = 0; $l < $n; $l++) {						
							$c[$i][$j] += $a[$i][$l]*$b[$l][$j];
						}
					}
				}
				for ($i = 0; $i < $n; $i++) {
					echo "<br>";
					for ($j = 0; $j < $n; $j++) {
						if ($c[$i][$j] > 1) {
							$c[$i][$j] = 1;
						}
						echo " ".$c[$i][$j];
					}
				}
				return $c;
			}
			
			function antisymmetry ($c) {
				global $n;
				$good = 1;
				for ($i = 0; $i < $n; $i++) {
					for ($j = 0; $j < $n; $j++) {
						if ($i != $j) {
							if ($c[$i][$j] != 0) {
								$good--;
							}
						}
					}
				}
				if ($good != 1) {
					echo "<br>Не кососимметрично";
				}
				else {
					echo "<br>Кососимметрично";
				}
			}
			
			function transitivity ($a) {
				global $n;
				$good = 0;
				for ($i = 0; $i < $n; $i++) {
					for ($j = 0; $j < $n; $j++) {
						if ($a[$i][$j] == 0) {
							$z++;
						}
						if ($a[$i][$j] == 1) {
							$o++;
						}
					}
				}
				if ($o <= $z) {
					$good++;
				}
				if ($good != 1) {
					echo "<br>Не транзитивно";
				}
				else {
					echo "<br>Транзитивно";
				}
			}
		?>
	</body>
</html>