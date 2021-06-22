<?php

include './example_persons_array.php';

/*
    Принимает как аргумент одну строку — склеенное ФИО. 
    Возвращает как результат массив из трёх элементов 
    с ключами 'name', 'surname' и 'patronomyc'.
*/
function getPartsFromFullname($fullname) {
    $fullname = explode(' ', $fullname);

    return [
        'surname' => $fullname[0],
        'name' => $fullname[1],
        'patronomyc' => $fullname[2],
    ];
}

/*
    Принимает как аргумент три строки — фамилию, имя и отчество. 
    Возвращает как результат их же, но склеенные через пробел.
*/
function getFullnameFromParts($surname, $name, $patronomyc) {
    return implode(' ', [$surname, $name, $patronomyc]);
}

/*
    Принимает как аргумент строку, содержащую ФИО вида 
    «Иванов Иван Иванович» и возвращающую строку вида «Иван И.», 
    где сокращается фамилия и отбрасывается отчество.
*/
function getShortName($fullname) {
    $fullname = getPartsFromFullname($fullname);
    $surname = mb_substr($fullname['surname'], 0, 1);

    return "${fullname['name']} ${surname}.";
}

/* Принимающет как аргумент строку, содержащую ФИО, для определения пола. */
function getGenderFromName($fullname) {
    $sum = 0;
    $fullname = getPartsFromFullname($fullname);

    $surname = $fullname['surname'];
    $name = $fullname['name'];
    $patronomyc = $fullname['patronomyc'];

    if ( mb_substr($surname, -2, 2) === 'ва' ) $sum -= 1;
    if ( mb_substr($surname, -1, 1) === 'в' ) $sum += 1;

    if ( mb_substr($name, -1, 1) === 'а' ) $sum -= 1;
    if ( mb_substr($name, -1, 1) === 'й' || mb_substr($name, -1, 1) === 'н' ) $sum += 1;

    if ( mb_substr($patronomyc, -3, 3) === 'вна' ) $sum -= 1;
    if ( mb_substr($patronomyc, -2, 2) === 'ич' ) $sum += 1;

    if ($sum > 0) return 1;
    elseif ($sum < 0) return -1;
    elseif ($sum === 0) return 0;
}

/* Определение полового состава аудитории. */
function getGenderDescription($array) {
    $mens = array_filter($array, function($val) {
        if (getGenderFromName($val['fullname']) === 1) return $val['fullname'];
    });

    $womens = array_filter($array, function($val) {
        if (getGenderFromName($val['fullname']) === -1) return $val['fullname'];
    });

    $undefined = array_filter($array, function($val) {
        if (getGenderFromName($val['fullname']) === 0) return $val['fullname'];
    });

    $mens = count($mens);
    $womens = count($womens);
    $undefined = count($undefined);

    $mens = round($mens / count($array) * 100, 1);
    $womens = round($womens / count($array) * 100, 1);
    $undefined = round($undefined / count($array) * 100, 1);

    return <<<EOT
    Гендерный состав аудитории: <br/>
    --------------------------- <br/>
    Мужчины - {$mens}% <br/>
    Женщины - {$womens}% <br/>
    Не удалось определить - {$undefined}% <br/>
    EOT;
}

/* Определение «идеальной» пары. */
function getPerfectPartner() {}

/* ################################################ */

?>
