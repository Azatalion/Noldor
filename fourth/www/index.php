<!DOCTYPE html>
<html>
	<head>
		<title>Лабораторная работа №4</title>
		<link type="text/css" rel="stylesheet" href="style.css">
	</head>
	<body>
		<h1>Лабораторная работа №4<br>Определение кратчайшего пути в графе</h1>
		<form method = "get" action = "index.php">
			<table>
				<tr>
					<td align = "center">
						<h2>Ввод данных</h2>
					</td>
				</tr>
				<tr>
					<td align = "center">
						<textarea name = "graph" type = "text" rows = "9" placeholder = "Весовая матрица"><?=$_GET['graph']?></textarea>
					</td>
				</tr>
				<tr>
					<td align = "center">
						<input name = "need" type = "text" placeholder = "Последняя вершина пути" value = "<?=$_GET['need']?>">
					</td>
				</tr>
				<tr>
					<td align = "center">
						<input class = "go" type = "submit" value = "Найти кратчайший путь">
					</td>
				</tr>
			</table>
		</form>
		<div class = "code">
			<?php
				$graph = explode(" ", $_GET['graph']);
				$top = $_GET['need'];
				$m = 1;
				$n = 1;
				$good = 1;
				if (implode("", $graph) == "") {
					echo "<p>Введите весовую матрицу</p>";
					$good--;
				}
				if ($top == "") {
					echo "<p>Введите вершину, до которой нужно найти кратчайший путь</p>";
					$good--;
				}
				if ($graph != "" && $top != "") {
					findTrue($graph);
					$max = getMax($graph);
					$graph = beGood($graph);
					validation($graph);
					if ($good == 1) {
						write ($graph);
						$way = findWay($graph);
						result($way);
					}
				}
				
				function findTrue($g) {
					global $m, $n;
					for ($i = 0; $i < count($g); $i++) {
						if (strlen($g[$i]) <= 3) {
							$m++;
						}
						else {
							$i =  count($g);
						}
					}
					for ($i = 0; $i < count($g); $i++) {
						if (strlen($g[$i]) > 3) {
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
				
				function getMax($g) {
					global $n;
					$max = $g[0];
					for ($i = 0; $i < count($g); $i++) {
						if (is_numeric($g[$i]) && $g[$i] > $max) {
							$max = $g[$i];
						}
					}
					return $max;
				}
				
				function beGood($g) {
					$k = 0;
					$may = 0;
					global $n, $max;
					for ($i = 0; $i < $n; $i++) {
						for ($j = 0; $j < $n; $j++) {
							if (strlen ($g[$k]) <= strlen($max)) {
								$gr[$i][$j] = $g[$k];
							}
							if (strlen ($g[$k]) > strlen($max)) {
								$gra = $g[$k];
								$l = 0;
								while (is_numeric($gra[$l]) || $gra[$l] == "-") {
									$gr[$i][$j] = $gr[$i][$j].$gra[$l];
									$l++;
								}
								$may++;
							}
							if ($may >= 1) {
								if (strlen ($g[$k - 1]) > strlen($max)) {
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
				
				function validation ($g) {
					global $n, $m, $top, $good;
					if ($n != $m && $n > 0 && $m > 0) {
						echo "<p>Матрица введена не полностью</p>";
						$good--;
					}
					if ($top > $n) {
						echo "<p>Такой вершины в графе нет</p>";
						$good--;
					}
					for ($i = 0; $i < $n; $i++) {
						for ($j = 0; $j < $n; $j++) {
							if (!is_numeric($g[$i][$j]) && $g[$i][$j] != "-") {
								echo "<p>Вес ребра не может принимать такое значения</p>";
								$good--;
							}
						}
					}
					return $good;
				}
				
				function write ($g) {
					echo "Весовая матрица:";
					global $n;
					for ($i = 0; $i < $n; $i++) {
						echo "<br>";
						for ($j = 0; $j < $n; $j++) {
							echo $g[$i][$j]." ";
						}
					}
				}
				
				function findWay ($g) {
					global $n, $max;
					$max++;
					for ($i = 0; $i < $n; $i++) {
							$d[$i] = $max;
							$v[$i] = 1;
					}
					$d[0] = 0;
					do {
						$mi = $max;
						$min = $max;
						for ($i = 0; $i < $n; $i++) {
							if ($v[$i] == 1 && $d[$i] < $min) {
								$min = $d[$i];
								$mi = $i;
							}
						}
						if ($mi != $max) {
							for ($i = 0; $i < $n; $i++) {
								if ($g[$mi][$i] > 0 && is_numeric($g[$mi][$i])) {
									$t = $min + $g[$mi][$i];
									if ($t < $d[$i]) {
										$d[$i] = $t;
									}
								}
							}
							$v[$mi] = 0;
						}
					} while ($mi < $max);
					return $d;
				}
					
				function result ($d) {
					global $n, $top;
					for ($i = 0; $i <= $n; $i++) {
						if ($i != 0 && $i == $top) {
							echo "<br> Кратчайший путь от вершины 1 до вершины ".$top." = ".$d[$i - 1];
						}
					}
				}
			?>
		</div>
	</body>
</html>