<?php

//Функция сравнения с легендой 
function legend($r_,$g_,$b_) {
//Если оттенки серого, то выходим возвращаем другое значение
if ($r_<$g_+8 && $r_>$g_-8 && $r_<$b_+8 && $r_>$b_-8) {return array(100 ,255,255,255);}

//if ($r_>0 && $r_<40 && $g_>230 && $g_<255 && $b_>0 && $b_<40) {$r_=0; $g_=255; $b_=0;} //Слабые осадки
if ($r_>192 && $r_<253 && $g_>187 && $g_<217 && $b_>207 && $b_<249) {$r_=255; $g_=0; $b_=0; $type_=5;} //Слабые осадки
if ($r_>124 && $r_<150 && $g_>222 && $g_<255 && $b_>120 && $b_<140) {$r_=0; $g_=255; $b_=0; $type_=6;} //Зеленый
//if ($r_>182 && $r_<255 && $g_>177 && $g_<227 && $b_>190 && $b_<255) {$r_=255; $g_=0; $b_=0; $type_=5;} //Слабые осадки
//if ($r_>0 && $r_<40 && $g_>230 && $g_<255 && $b_>0 && $b_<40) {$r_=0; $g_=255; $b_=0;} //Слабые осадки
//if ($r_>0 && $r_<40 && $g_>230 && $g_<255 && $b_>0 && $b_<40) {$r_=0; $g_=255; $b_=0;} //Слабые осадки
return array($type_ ,$r_,$g_,$b_);
};


//Файл, который мы будет конвертировать
$file = 'clear.jpg';
$file2 = 'tuchki.jpg';
// Поле заголовка
header('Content-type: image/jpeg');
// Размеры изображения
list($width, $height) = getimagesize($file);
// Создаем изображение JPEG из файла
$source = imagecreatefromjpeg($file);
$weather = imagecreatefromjpeg($file2);


// Считываем оригинальное изображение по пикселям
for ($y=0;$y<$height;$y++)
{
for ($x=0;$x<$width;$x++)
{
$rgbw = imagecolorat($weather,$x,$y); //определяем значение цвета пикселя с погодой
$rw = ($rgbw >> 16) & 0xFF;
$gw = ($rgbw >> 8) & 0xFF;
$bw = $rgbw & 0xFF;

$rgb = imagecolorat($source,$x,$y); //определяем значение цвета пикселя без погоды
$r = ($rgb >> 16) & 0xFF;
$g = ($rgb >> 8) & 0xFF;
$b = $rgb & 0xFF;

$rw=abs($rw-$r);
$gw=abs($gw-$g);
$bw=abs($bw-$b);
//Инверсия цветов
$rw=255-$rw;
$gw=255-$gw;
$bw=255-$bw;


//Проверка пикселя на наличие в легенде
//list($rw,$gw,$bw)=legend($type,$rw,$gw,$bw);
//if (($rw<>0) & ($gw<>0) &($bw<>0))
//{
//    $handle = fopen("tuchki.txt", "a-");
//    fwrite($handle, " X: ".$x." Y:".$y." R: ".$rw." G: ".$gw." B: ".$bw."
//    ");
//}
//Запомним значение цвета пикселя
$current = imagecolorallocate($weather, $rw, $gw, $bw); 
//Установим значение цвета пикселя
imagesetpixel($weather,$x,$y,$current);
}
}

//работаем с уже обработаной картинкой (устраняем шумы)
for ($y=0;$y<$height;$y++)
{
for ($x=0;$x<$width;$x++)
{
//вычисляем средний цвет по квадратам
//делаем квадрат 3*3, предполагаем что этот пиксель Первый  	Х__
//								___ 
$rgb1 = imagecolorat($weather,$x,$y);
$rw1 = ($rgb1 >> 16) & 0xFF;
$gw1 = ($rgb1 >> 8) & 0xFF;
$bw1 = $rgb1 & 0xFF;
$rgb2 = imagecolorat($weather,$x+1,$y);
$rw2 = ($rgb2 >> 16) & 0xFF;
$gw2 = ($rgb2 >> 8) & 0xFF;
$bw2 = $rgb2 & 0xFF;
$rgb3 = imagecolorat($weather,$x+2,$y);
$rw3 = ($rgb3 >> 16) & 0xFF;
$gw3 = ($rgb3 >> 8) & 0xFF;
$bw3 = $rgb3 & 0xFF;
$rgb4 = imagecolorat($weather,$x,$y+1);
$rw4 = ($rgb4 >> 16) & 0xFF;
$gw4 = ($rgb4 >> 8) & 0xFF;
$bw4 = $rgb4 & 0xFF;
$rgb5 = imagecolorat($weather,$x+1,$y+1);
$rw5 = ($rgb5 >> 16) & 0xFF;
$gw5 = ($rgb5 >> 8) & 0xFF;
$bw5 = $rgb5 & 0xFF;
$rgb6 = imagecolorat($weather,$x+2,$y+1);
$rw6 = ($rgb6 >> 16) & 0xFF;
$gw6 = ($rgb6 >> 8) & 0xFF;
$bw6 = $rgb6 & 0xFF;
$rgb7 = imagecolorat($weather,$x,$y+2);
$rw7 = ($rgb7 >> 16) & 0xFF;
$gw7 = ($rgb7 >> 8) & 0xFF;
$bw7 = $rgb7 & 0xFF;
$rgb8 = imagecolorat($weather,$x+1,$y+2);
$rw8 = ($rgb8 >> 16) & 0xFF;
$gw8 = ($rgb8 >> 8) & 0xFF;
$bw8 = $rgb8 & 0xFF;
$rgb9 = imagecolorat($weather,$x+2,$y+2);
$rw9 = ($rgb9 >> 16) & 0xFF;
$gw9 = ($rgb9 >> 8) & 0xFF;
$bw9 = $rgb9 & 0xFF;

//высчитываем среднее значение
$rw1=($rw9+$rw8+$rw7+$rw6+$rw5+$rw4+$rw3+$rw2+$rw1)/9;
$gw1=($gw9+$gw8+$gw7+$gw6+$gw5+$gw4+$gw3+$gw2+$gw1)/9;
$bw1=($bw9+$bw8+$bw7+$bw6+$bw5+$bw4+$bw3+$bw2+$bw1)/9;
//$current = imagecolorallocate($weather, $rw1, $gw1, $bw1);
//imagesetpixel($weather,$x,$y,$current);
//если пиксель попадет в легенду, то разукрасим квадрат.
list($type,$r,$g,$b)=legend($rw1,$gw1,$bw1);
if ($type==5 or  $type==100 or $type==6) 
    {
    $current = imagecolorallocate($weather, $r, $g, $b);
    imagesetpixel($weather,$x,$y,$current);
    imagesetpixel($weather,$x+1,$y,$current);
    imagesetpixel($weather,$x+2,$y,$current);
    imagesetpixel($weather,$x,$y+1,$current);
    imagesetpixel($weather,$x+1,$y+1,$current);
    imagesetpixel($weather,$x+2,$y+1,$current);
    imagesetpixel($weather,$x,$y+2,$current);
    imagesetpixel($weather,$x+1,$y+2,$current);
    imagesetpixel($weather,$x+2,$y+2,$current);

    $x++;
    }
}
}

//fclose($handle); // закрываем файл лога
// Выводим в браузер преобразованное изображение
//imagejpeg($source);
imagejpeg($weather, NULL, 100);
?>