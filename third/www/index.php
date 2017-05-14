<!DOCTYPE html>
<html>
	<head>
		<title>Лабораторная работа №3</title>
		<link type="text/css" rel="stylesheet" href="style.css">
	</head>
	<body>
		<h1>Функции</h1>
		<form method = "post" action = "index.php">
			<table>
				<tr>
					<td align = "centr">
						<h2>Тип ввода: матрица n*n</h2>
					</td>
				<tr>
					<td align = "center">
						<textarea name = "attitude" type = "text" placeholder = "Отношение" rows = "9"><?=$_POST['attitude']?></textarea>
					</td>
				</tr>
				<tr>
					<td align = "center">
						<input class = "go" type = "submit" value = "Проверить, является ли функцией">
					</td>
				</tr>
			</table>
		</form>
		<div class = "code">
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
						check($attitude);
					}
				}
				else {
					echo "<p>Введите отношение</p>";
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
						$good--;
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
				
				function check ($a) {
					$one = 0;
					$good = 0;
					global $n;
					for ($i = 0; $i < $n; $i++) {
						$one = 0;
						for ($j = 0; $j < $n; $j++) {
							if ($a[$i][$j] == 1) {
								$one++;
							}
						}
						if ($one == 1) {
							$good++;
						}
						else {
							$good--;
						}
					}
					if ($good == $n) {
						echo "<br>Данное отношение является функцией";
					}
					else {
						echo "<br>Данное отношение не является функцией";
					}
				}
		
		
			?>
		</div>
	</body>
</html>