<?php

// 判断一个 9x9 的数独是否有效。只需要根据以下规则，验证已经填入的数字是否有效即可。
//
//数字 1-9 在每一行只能出现一次。
//数字 1-9 在每一列只能出现一次。
//数字 1-9 在每一个以粗实线分隔的 3x3 宫内只能出现一次。
//
//
//上图是一个部分填充的有效的数独。
//
//数独部分空格内已填入了数字，空白格用 '.' 表示。
//
//示例 1:
//
//输入:
//[
//  ["5","3",".",".","7",".",".",".","."],
//  ["6",".",".","1","9","5",".",".","."],
//  [".","9","8",".",".",".",".","6","."],
//  ["8",".",".",".","6",".",".",".","3"],
//  ["4",".",".","8",".","3",".",".","1"],
//  ["7",".",".",".","2",".",".",".","6"],
//  [".","6",".",".",".",".","2","8","."],
//  [".",".",".","4","1","9",".",".","5"],
//  [".",".",".",".","8",".",".","7","9"]
//]
//输出: true
//示例 2:
//
//输入:
//[
//  ["8","3",".",".","7",".",".",".","."],
//  ["6",".",".","1","9","5",".",".","."],
//  [".","9","8",".",".",".",".","6","."],
//  ["8",".",".",".","6",".",".",".","3"],
//  ["4",".",".","8",".","3",".",".","1"],
//  ["7",".",".",".","2",".",".",".","6"],
//  [".","6",".",".",".",".","2","8","."],
//  [".",".",".","4","1","9",".",".","5"],
//  [".",".",".",".","8",".",".","7","9"]
//]
//输出: false
//解释: 除了第一行的第一个数字从 5 改为 8 以外，空格内其他数字均与 示例1 相同。
//     但由于位于左上角的 3x3 宫内有两个 8 存在, 因此这个数独是无效的。
//说明:
//
//一个有效的数独（部分已被填充）不一定是可解的。
//只需要根据以上规则，验证已经填入的数字是否有效即可。
//给定数独序列只包含数字 1-9 和字符 '.' 。
//给定数独永远是 9x9 形式的。
//
//来源：力扣（LeetCode）
//链接：https://leetcode-cn.com/problems/valid-sudoku
//著作权归领扣网络所有。商业转载请联系官方授权，非商业转载请注明出处。

class Solution
{

    /**
     * 另一种思路, 横纵判断有无重复, 分9格分别判断是否重复
     * 循环了 162 次
     * @param $board
     * @return bool
     */
    function isValidSudoku($board)
    {
        // 横纵轴判断, 循环 81 次
        for ($i = 0; $i < 9; $i++) {
            $hash = [];
            $hash2 = [];
            for ($j = 0; $j < 9; $j++) {
                if ($board[$i][$j] !== '.') {
                    if (isset($hash[$board[$i][$j]])) {
                        return false;
                    }
                    $hash[$board[$i][$j]] = true;
                }
                if ($board[$j][$i] !== '.') {
                    if (isset($hash2[$board[$j][$i]])) {
                        return false;
                    }

                    $hash2[$board[$j][$i]] = true;
                }
            }
        }
        // 3*3 判断, 循环 81 次
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $hash = [];
                for ($x = $i * 3; $x < $i * 3 + 3; $x++) {
                    for ($y = $j * 3; $y < $j * 3 + 3; $y++) {
                        if ($board[$x][$y] === '.') {
                            continue;
                        }
                        if (isset($hash[$board[$x][$y]])) {
                            return false;
                        }
                        $hash[$board[$x][$y]] = true;
                    }
                }
            }
        }

        return true;
    }

    /**
     * 遍历就完事了, 这题考察边界条件
     * 循环了 1458 次
     * @param String[][] $board
     * @return Boolean
     */
    function isValidSudoku1($board)
    {
        // 循环 9*9*(9+9) = 1458 次
        for ($x = 0; $x < 9; $x++) {
            for ($y = 0; $y < 9; $y++) {
                $num = $board[$y][$x];
                if ($num !== '.') {
                    if (!$this->check3($board, $x, $y) || !$this->checkXY($board, $x, $y)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    function checkXY($board, $x, $y)
    {
        $num = $board[$y][$x];
        for ($i = 0; $i < 9; $i++) {
            if ($x !== $i && $board[$y][$i] === $num) {
                return false;
            }
            if ($y !== $i && $board[$i][$x] === $num) {
                return false;
            }
        }
        return true;
    }

    function check3($board, $x, $y)
    {
        $num = $board[$y][$x];
        $oldX = $x;
        $oldY = $y;
        $x = $x - $x % 3;
        $y = $y - $y % 3;
        for ($i = $x; $i < $x + 3; $i++) {
            for ($j = $y; $j < $y + 3; $j++) {
                if ($oldX === $i && $oldY === $j) {
                    // 相同的点不算
                } else {
                    $newNum = $board[$j][$i];
                    if ($newNum !== '.' && $num === $newNum) {
                        return false;
                    }
                }
            }
        }
        return true;
    }
}

$s = new Solution();


$s1 = [
    ["5", "3", ".", ".", "7", ".", ".", ".", "."],
    ["6", ".", ".", "1", "9", "5", ".", ".", "."],
    [".", "9", "8", ".", ".", ".", ".", "6", "."],
    ["8", ".", ".", ".", "6", ".", ".", ".", "3"],
    ["4", ".", ".", "8", ".", "3", ".", ".", "1"],
    ["7", ".", ".", ".", "2", ".", ".", ".", "6"],
    [".", "6", ".", ".", ".", ".", "2", "8", "."],
    [".", ".", ".", "4", "1", "9", ".", ".", "5"],
    [".", ".", ".", ".", "8", ".", ".", "7", "9"]
];

var_dump($s->isValidSudoku($s1)); // true

$s2 = [["8", "3", ".", ".", "7", ".", ".", ".", "."],
    ["6", ".", ".", "1", "9", "5", ".", ".", "."],
    [".", "9", "8", ".", ".", ".", ".", "6", "."],
    ["8", ".", ".", ".", "6", ".", ".", ".", "3"],
    ["4", ".", ".", "8", ".", "3", ".", ".", "1"],
    ["7", ".", ".", ".", "2", ".", ".", ".", "6"],
    [".", "6", ".", ".", ".", ".", "2", "8", "."],
    [".", ".", ".", "4", "1", "9", ".", ".", "5"],
    [".", ".", ".", ".", "8", ".", ".", "7", "9"],
];

var_dump($s->isValidSudoku($s2)); // false

$s3 = [
    [".", ".", ".", ".", "5", ".", ".", "1", "."],
    [".", "4", ".", "3", ".", ".", ".", ".", "."],
    [".", ".", ".", ".", ".", "3", ".", ".", "1"],
    ["8", ".", ".", ".", ".", ".", ".", "2", "."],
    [".", ".", "2", ".", "7", ".", ".", ".", "."],
    [".", "1", "5", ".", ".", ".", ".", ".", "."],
    [".", ".", ".", ".", ".", "2", ".", ".", "."],
    [".", "2", ".", "9", ".", ".", ".", ".", "."],
    [".", ".", "4", ".", ".", ".", ".", ".", "."]
];

var_dump($s->isValidSudoku($s3)); // false