<!DOCTYPE html>
<html>
	<head>
		<title>Лабораторная работа №1</title>
		<link type="text/css" rel="stylesheet" href="style.css">
	</head>
	<body>
		<h1>Лабораторная работа №1<br>Операции над множествами</h1>
		<form method = "post" action = "index.php">
			<table>
				<tr>
					<td align = "center">
						<h2>Тип ввода элемента множества: буква, цифра, чётная цифра</h2>
					</td>
				</tr>
				<tr>
					<td align = "center">
						<input name = "first" type = "text" placeholder = "Первое множество" value = "<?=$_POST['first']?>">
					</td>
				</tr>
				<tr>
					<td align = "center">
						<input name = "second" type = "text" placeholder = "Второе множество" value = "<?=$_POST['second']?>">
					</td>
				</tr>
				<tr>
					<td align = "center">
						<input class = "go" type = "submit" value = "Выполнить операции">
					</td>
				</tr>
			</table>
		</form>
		<div class = "code">
			<?php
				$number = 0;
				$good = 0;
				$varietyA = explode (" ", $_POST['first']);
				$varietyB = explode (" ", $_POST['second']);
				if($_POST['first'] != "" && $_POST['second'] != "") {
					$varietyA = noRepeat($varietyA);
					$varietyB = noRepeat($varietyB);
					echo "Первое множество: ".implode (" ", $varietyA);
					echo "<br>Второе множество: ".implode (" ", $varietyB);
					$varietyA = beGood($varietyA);
					$varietyB = beGood($varietyB);
					validation($varietyA);
					validation($varietyB);
					if ($good > 1) {
						echo "<br>Объединение: ".association ($varietyA, $varietyB);
						echo "<br>Пересечение: ".intersection ($varietyA, $varietyB);
						echo "<br>Дополнение первого множества до второго: ".additionA ($varietyA, $varietyB);
						echo "<br>Дополнение второго множества до первого: ".additionB ($varietyA, $varietyB);
						echo "<br>Симметрическая разность: ".difference ($varietyA, $varietyB);
					}
				}
				if ($_POST['first'] == "") {
					echo "<p>Введите первое множество</p>";
				}
				if ($_POST['second'] == "") {
					echo "<p>Введите второе множество</p>";
				}

				function noRepeat ($variety) {
					$variety = array_unique($variety);
					return $variety;
				}
				
				function beGood ($variety) {
					$variety = implode (" ",$variety);
					$variety = explode (" ",$variety);
					return $variety;
				}
			
				function validation ($variety) {
					global $number, $good;
					$number++;
					for ($i = 0; $i < count($variety); $i++) {
						$val = $variety[$i];
						if (strlen($val) == 3) {
							if(!preg_match('/[a-zA-Z]/', $val[0])) {
								$letter++;
								$l = $i + 1;
								echo "<p>Первый символ ".$l."-го элемента ".$number."-го множества должен быть буквой</p>";
							}
							if(!is_numeric($val[1])) {
								$num++;
								$n = $i + 1;
								echo "<p>Второй символ ".$n."-го элемента ".$number."-го множества должен быть цифрой</p>";
							}
							if($val[2]%2 != 0 || !is_numeric($val[2])) {
								$even++;
								$e = $i + 1;
								echo "<p>Третий символ ".$e."-го элемента ".$number."-го множества должен быть чётной цифрой</p>";
							}
						}
						else {
							echo "<p>Элементы ".$number."-го множества должны состоять из трёх символов</p>";
							$good--;
						}
					}
					if ($letter > 0) {
						$letter = 0;
						$good--;
					}
					if ($num > 0) {
						$num = 0;
						$good--;
					}
					if ($even > 0) {
						$even = 0;
						$good--;
					}
					else {
						$good++;
					}
					return $good;
				}
					
				function association ($a, $b) {
					$m = count($b);
					for ($i = 0; $i <= count($a); $i++) {
						for ($j = 0; $j <= $m; $j++) {
							if($a[$i] == $b[$j]) {
								unset($b[$j]);
							}
						}
					}
					$result = implode(" ", $a)." ".implode(" ", $b);
					return $result;
				}
				
				function intersection ($a, $b) {
					for ($i = 0; $i <= count($a); $i++) {
						for ($j = 0; $j <= count($b); $j++) {
							if($a[$i] == $b[$j]) {
								$result = $result." ".$a[$i];
							}
						}
					}
					return $result;
				}
				
				function additionA ($a, $b) {
					$m = count($b);
					for ($i = 0; $i <= count($a); $i++) {
						for ($j = 0; $j <= $m; $j++) {
							if($a[$i] == $b[$j]) {
								unset($b[$j]);
							}
						}
					}
					$result = implode(" ", $b);
					return $result;
				}
				
				function additionB ($a, $b) {
					$n = count($a);
					for ($i = 0; $i <= $n; $i++) {
						for ($j = 0; $j <= count($b); $j++) {
							if($a[$i] == $b[$j]) {
								unset($a[$i]);
							}
						}
					}
					$result = implode(" ", $a);
					return $result;
				}
				
				function difference ($a, $b) {
					$n = count($a);
					$m = count($b);
					for ($i = 0; $i <= $n; $i++) {
						for ($j = 0; $j <= $m; $j++) {
							if($a[$i] == $b[$j]) {
								unset($a[$i]);
								unset($b[$j]);
							}
						}
					}
					$result = implode(" ", $a)." ".implode(" ", $b);
					return $result;
				}
			?>
		</div>
	</body>
</html>