<!DOCTYPE html>
<html>
	<head>
		<title>Лабораторная работа №5</title>
		<link type="text/css" rel="stylesheet" href="style1.css">
	</head>
	<body>
		<h1>Лабораторная работа №5<br>Нахождение матрицы достижимости</h1>
		<form method = "post" action = "index.php">
			<table>
				<tr>
					<td align = "center">
						<h2>Ввод данных</h2>
					</td>
				</tr>
				<tr>
					<td align = "center">
						<textarea name = "adjacency" type = "text" placeholder = "Матрица смежности" rows = "9"><?=$_POST['adjacency']?></textarea>
					</td>
				</tr>
				<tr>
					<td align = "center">
						<input class = "go" type = "submit" value = "Найти матрицу достижимости">
					</td>
				</tr>
			</table>
		</form>
		<div class = "code">
			<?php
				$m = 1;
				$n = 1;
				$good = 1;
				$adjacency = explode(" ", $_POST['adjacency']);
				if (implode("",$adjacency) == "") {
					echo "<p>Введите матрицу смежности</p>";
					$good--;
				}
				if ($adjacency != "") {
					findTrue($adjacency);
					$adjacency = beGood($adjacency);
					validation($adjacency);
					if ($good == 1) {
						attainability($adjacency);
					}
				}
				
				function findTrue($g) {
					global $m, $n;
					for ($i = 0; $i < count($g); $i++) {
						if (strlen($g[$i]) <= 1) {
							$m++;
						}
						else {
							$i =  count($g);
						}
					}
					for ($i = 0; $i < count($g); $i++) {
						if (strlen($g[$i]) > 1) {
							$n++;
						}
					}
					if ($n == 1) {
						$m--;
					}
					if ($m == 1) {
						$n--;
					}
					return $m; return $n;
				}
				
				function beGood($g) {
					$k = 0;
					$may = 0;
					global $m, $n;
					for ($i = 0; $i < $n; $i++) {
						for ($j = 0; $j < $m; $j++) {
							if (strlen ($g[$k]) == 1) {
								$gr[$i][$j] = $g[$k];
							}
							if (strlen ($g[$k]) > 1) {
								$gra = $g[$k];
								$l = 0;
								while (is_numeric($gra[$l])) {
									$gr[$i][$j] = $gr[$i][$j].$gra[$l];
									$l++;
								}
								$may++;
							}
							if ($may >= 1) {
								if (strlen ($g[$k - 1]) > 1) {
									$gra = $g[$k - 1];
									$gr[$i][$j] = "";
									for ($l = 3; $l < strlen($gra); $l++) {
										$gr[$i][$j] = $gr[$i][$j].$gra[$l];
									}
									$may--;
									$k--;
								}
							}
							$k++;
						}
					}
					return $gr;
				}
				
				function validation ($a) {
					global $n, $m, $good;
					
					if ($n != $m && $n > 0 && $m > 0) {
						echo "<p>Матрица введена не полностью</p>";
						$good--;
					}
					for ($i = 0; $i < $n; $i++) {
						for ($j = 0; $j < $n; $j++) {
							if (!is_numeric($a[$i][$j]) || ($a[$i][$j] != 0 && $a[$i][$j] != 1)) {
								echo "<p>Некорректный элемент ".$i." строки ".$j." столбца</p>";
								$good--;
							}
						}
					}
					return $good;
				}

				function attainability ($a) {
					global $n;
					for ($i = 0; $i < $n; $i++) {
						for ($j = 0; $j < $n; $j++) {
							$w[$i][$j] = $a[$i][$j];
						}
					}
					for ($k = 0; $k < $n; $k++) {
						echo "<br>W<sub>".($k + 1)."</sub>";
						if ($k + 1 == $n) {
							echo " = M<sup>*</sup>";
						}
						echo "<br>";
						for ($i = 0; $i < $n; $i++) {
							if ($w[$i][$k] == 0) {
								for ($j = 0; $j < $n; $j++) {
									$w[$i][$j] = $w[$i][$j];
									echo $w[$i][$j]." ";
								}
							}
							if ($w[$i][$k] == 1) {
								for ($j = 0; $j < $n; $j++) {
									$w[$i][$j] = $w[$k][$j] + $w[$i][$j];
									if ($w[$i][$j] > 1) {
										$w[$i][$j] = 1;
									}
									echo $w[$i][$j]." ";
								}
							}
							echo "<br>";
						}
					}
					return $w;
				}
			?>
		</div>
	</body>
</html>