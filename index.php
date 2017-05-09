<!DOCTYPE html>
<html>
	<head>
		<title>Лабораторная работа №1</title>
		<link type="text/css" rel="stylesheet" href="style.css">
	</head>
	<body>
		<h1>Тип ввода элемента множества: буква, цифра, чётная цифра</h1>
		<form method = "get" action = "index.php">
			<div>
				<input name = "first" type = "text" placeholder = "Первое множество" value = "<?=$_GET['first']?>">
			</div>
			<div>
				<input name = "second" type = "text" placeholder = "Второе множество" value = "<?=$_GET['second']?>">
			</div>
			<div><input type = "submit" value = "Выполнить операции"></div>
		</form>
		<?php
			$number = 0;
			$good = 0;
			$varietyA = explode (" ", $_GET['first']);
			$varietyB = explode (" ", $_GET['second']);
			if($_GET['first'] != "" && $_GET['second'] != "") {
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
			if ($_GET['first'] == "") {
				echo "<p>Введите первое множество</p>";
			}
			if ($_GET['second'] == "") {
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
				$n = count($a);
				for ($i = 0; $i <= $n; $i++) {
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
		?>
	</body>
</html>