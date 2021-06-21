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
function getGenderFromName() {}

/* Определение полового состава аудитории. */
function getGenderDescription() {}

/* Определение «идеальной» пары. */
function getPerfectPartner() {}

/* ################################################ */

?>
