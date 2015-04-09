<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <style>
        body {
            font-size: 12px;
        }
        td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h3>Задание 1 (переменные разных типов)</h3>
    <table>
        <thead>
            <tr>
                <th>Тип</th>
                <th>Значение</th>
                <th>var_dump()</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $v_int = 7;
                $v_float = 7.77;
                $v_string = '7string_value';
                $v_bool = true;
                define('CONST_INT', 3);
                define('CONST_FLOAT', 3.33);
                define('CONST_STRING', 'const3_string');
                define('CONST_BOOL', false);

                $v_arr = array('integer' => $v_int,
                          'float' => $v_float,
                          'string' => $v_string,
                          'boolean' => $v_bool,
                          'const integer' => CONST_INT,
                          'const float' => CONST_FLOAT,
                          'const string' => CONST_STRING,
                          'const boolean' => CONST_BOOL);

                foreach ($v_arr as $key => $value) {
                    echo "<tr><td>" . $key . "</td><td>" . $value . "</td><td>";
                    var_dump($value);
                    echo "</td></tr>";
                }
            ?>
        </tbody>
    </table>

    <h3>Задание 2 (вывод в двойных кавычках)</h3>
    <table>
        <thead>
            <tr>
                <th>Тип</th>
                <th>Значение</th>
                <th>var_dump()</th>
            </tr>
            </thead>
        <tbody>
            <?php
                foreach ($v_arr as $key => $value) {
                    echo "<tr><td>" . $key . "</td><td>" . "$value" . "</td><td>";
                    var_dump("$value");
                    echo "</td></tr>";
                }
            ?>
        </tbody>
    </table>
    <code>
        Отличий от первого задания нет, так как переменные в строках,
        указанных в двойных кавычках обрабатываются. В результате выводится
        их содержимое, приведенное к типу string.
    </code>

    <h3>Задание 3 (вывод в одинарных кавычках)</h3>
    <table>
        <thead>
        <tr>
            <th>Тип</th>
            <th>Значение</th>
            <th>var_dump()</th>
        </tr>
        </thead>
        <tbody>
            <?php
                foreach ($v_arr as $key => $value) {
                    echo "<tr><td>" . $key . "</td><td>" . '$value' . "</td><td>";
                    var_dump('$value');
                    echo "</td></tr>";
                }
            ?>
        </tbody>
    </table>
    <code>
        В данном случае переменные не обрабатываются и выводится не содержимое
        переменной, а текст, как он был указан между одинарными кавычками.
    </code>

    <h3>Задание 4 (выражения с использованием разных типов данных)</h3>
    <table>
        <thead>
        <tr>
            <th>Выражение</th>
            <th>Значение</th>
            <th>var_dump()</th>
        </tr>
        </thead>
        <tbody>
            <?php
                echo "<tr><td>int(7) + float(7.77)</td><td>" . ($v_int + $v_float) . "</td><td>";
                var_dump($v_int + $v_float);
                echo "</td></tr>";
             ?>
            <tr>
                <td colspan="3">
                    <code>
                        В любой операции с целыми числами, при появлении числа с плавающей запятой,<br>
                        результат будет числом с плавающей запятой.
                    </code>
                </td>
            </tr>
            <?php
                echo "<tr><td>string(\"7string_value\") + int(7)</td><td>" . ($v_string + $v_int) . "</td><td>";
                    var_dump($v_string + $v_int);
                echo "</td></tr>";
            ?>
            <?php
                echo "<tr><td>float(7.77) * CONST_STRING(\"const3_string\")</td><td>" . ($v_float * CONST_STRING) . "</td><td>";
                    var_dump($v_float * CONST_STRING);
                echo "</td></tr>";
            ?>
            <tr>
                <td colspan="3">
                    <code>
                        В любой арифметической операции с числами и строками, будет выполнена попытка<br>
                        привести начальную часть строки к числу. При неудаче вместо строки будет использован 0.
                    </code>
                </td>
            </tr>
            <?php
                echo "<tr><td>float(7.77) + boolean(true)</td><td>" . ($v_float + $v_bool) . "</td><td>";
                    var_dump($v_float + $v_bool);
                echo "</td></tr>";
            ?>
            <?php
                echo "<tr><td>int(7) * CONST_BOOL(false)</td><td>" . ($v_int * CONST_BOOL) . "</td><td>";
                    var_dump($v_int * CONST_BOOL);
                echo "</td></tr>";
            ?>
            <tr>
                <td colspan="3">
                    <code>
                        В любой арифметической операции булевы переменные приводятся к числу 0, если они равны:<br>
                        bool false, числу 0, пустой строке и строке "0" и некоторым другим значениям.<br>
                        В остальных случаях интерпретируются как число 1.
                    </code>
                </td>
            </tr>

        </tbody>
    </table>

    <h3>Задание 5 (оператор XOR)</h3>
    <code>
        Логический оператор XOR (исключающее или) возвращает true, если один из операндов равен true.<br>
        В противном случае возвращает false. Удобно использовать для превращения значения булевой <br>
        переменной в противоположное.
    </code>
    <table>
        <thead>
            <tr>
                <th>a</th>
                <th>b</th>
                <th>xor</th>
            </tr>
        </thead>
        <tbody>
        <?php
            echo "<tr><td>true</td><td>true</td><td>";
            var_dump(true xor true);
            echo "</td></tr>";
            echo "<tr><td>true</td><td>false</td><td>";
            var_dump(true xor false);
            echo "</td></tr>";
            echo "<tr><td>false</td><td>true</td><td>";
            var_dump(false xor true);
            echo "</td></tr>";
            echo "<tr><td>false</td><td>false</td><td>";
            var_dump(false xor false);
            echo "</td></tr>";
        ?>
         </tbody>
    </table>
    <code>
        Для любых значений $a, результат $a xor $a будет равен false в булевом выражении<br>
        поскольку оба операнда будут приведены к одинаковым булевым значениям, а результат <br>
        xor для одинаковых операндов равен false.
    </code>
    <br><br>

</body>
</html>