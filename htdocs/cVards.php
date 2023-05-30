<?php
class cVards
{
    var $dzimte = 1; // 1 - vīriešu, 2 - sieviešu, 3 - kopdzimte
    var $vards = '';
    var $deklinacija = 0;
    var $iznemums = false;
    var $locijumi = array();
    var $hl = 1;

    function __construct($vards, $dzimte = 1)
    {
        $this->dzimte = $dzimte;
        $this->vards = mb_strtolower($vards);
        $this->dekline();
        if($this->galotne == 0){
            return false;
        }
    }

    function dekline()
    {
        $gal1 = mb_substr($this->vards, -1);
        $gal2 = mb_substr($this->vards, -2);
        $v = $this->vards;
        $d = '';
        if ($this->dzimte == 1) {
            // viir. dz.
            //   I - s, sh, is, us
            //  II - is + mēness, akmens, asmens, rudens, ūdens, zibens, suns, sāls
            // III - us
            //  IV - a
            //   V - e
            //  VI - ļaudis
            if (
                $this->vards == 'mēness' ||
                $this->vards == 'akmens' ||
                $this->vards == 'asmens' ||
                $this->vards == 'rudens' ||
                $this->vards == 'ūdens' ||
                $this->vards == 'zibens' ||
                $this->vards == 'suns' ||
                $this->vards == 'sāls'
            ) {
                $this->deklinacija = 2;
                $this->iznemums = true;
                $this->galotne = 's';
            } else if ($this->vards == 'ļaudis') {
                $this->deklinacija = 6;
                $this->iznemums = true;
                $this->galotne = 'is';
            } else if ($gal2 == 'is') {
                $this->deklinacija = 2;
                $this->hl = 2;
                $this->galotne = $gal2;
            } else if ($gal2 == 'us') {
                $this->deklinacija = 3;
                $this->hl = 2;
                $this->galotne = $gal2;
            } else if ($gal1 == 's' || $gal1 == 'š') {
                $this->deklinacija = 1;
                $this->hl = 1;
                $this->galotne = $gal1;
            } else if ($gal1 == 'a') {
                $this->deklinacija = 4;
                $this->hl = 1;
                $this->galotne = $gal1;
            } else if ($gal1 == 'e') {
                $this->deklinacija = 5;
                $this->hl = 1;
                $this->galotne = $gal1;
            }
        } else if ($this->dzimte == 2) {
            // siev. dz. - IV, V, VI
            //  IV - a
            //   V - e
            //  VI - s
            $this->hl = 1;
            if ($gal1 == 'a') {
                $this->deklinacija = 4;
                $this->galotne = $gal1;
                $this->hl = 1;
            } else if ($gal1 == 'e') {
                $this->deklinacija = 5;
                $this->galotne = $gal1;
                $this->hl = 1;
            } else if ($gal1 == 's') {
                $this->deklinacija = 6;
                $this->galotne = $gal1;
                $this->hl = 1;
            }
        } else {
            // siev. dz. - IV, V, VI
            //  IV - a
            //   V - e
            //  VI - s
            $this->hl = 1;
            if ($gal1 == 'a') {
                $this->deklinacija = 4;
                $this->galotne = $gal1;
                $this->hl = 1;
            } else if ($gal1 == 'e') {
                $this->deklinacija = 5;
                $this->hl = 1;
                $this->galotne = $gal1;
            }
        }
        if(!isset($this->galotne)){
            $this->galotne = 0;
            return;
        }
        $this->hl = mb_strlen($this->galotne);
        return $d;
    }

    function locit()
    {
        $q = $this->vards;
        $d = mb_substr($this->vards, 0, -$this->hl);
        $g = $this->galotne;
        if (
            $this->deklinacija == 1 ||
            $this->deklinacija == 2 ||
            $this->deklinacija == 3
        ) {
            if (
                $this->deklinacija == 2 && !(
                    $q == 'tētis' ||
                    $q == 'viesis' ||
                    mb_substr($q, -5) == 'astis' ||
                    mb_substr($q, -3) == 'jis' ||
                    mb_substr($q, -3) == 'ķis' ||
                    mb_substr($q, -3) == 'ģis' ||
                    mb_substr($q, -3) == 'ris' ||
                    mb_substr($q, -6) == 'skatis')
            ) {
                $d1 = $this->mija($d, $this->deklinacija);
            } else {
                $d1 = $d;
            }
            $m[0] = $d1 . 'i';
            $m[1] = $d1 . 'u';
            $m[2] = $d1 . 'iem';
            $m[3] = $d1 . 'us';
            $m[4] = 'ar ' . $d1 . 'iem';
            $m[5] = $d1 . 'os';
            $m[6] = $d1 . 'i!';
        }
        if ($this->deklinacija == 1) {
            $l[0] = $d . $g;
            $l[1] = $d . 'a';
            $l[2] = $d . 'am';
            $l[3] = $d . 'u';
            $l[4] = 'ar ' . $d . 'u';
            $l[5] = $d . 'ā';
            $l[6] = $d . ($g == 's' ? 's' : 'š');

        } else if ($this->deklinacija == 2) {

            if (
                !$this->iznemums && !(
                    $q == 'tētis' ||
                    $q == 'viesis' ||
                    mb_substr($q, -5) == 'astis' ||
                    mb_substr($q, -3) == 'jis' ||
                    mb_substr($q, -3) == 'ķis' ||
                    mb_substr($q, -3) == 'ģis' ||
                    mb_substr($q, -3) == 'ris' ||
                    mb_substr($q, -6) == 'skatis')
            ) {
                $d1 = $this->mija($d, $this->deklinacija);
            } else {
                $d1 = $d;
            }
            $l[0] = $d . $g;
            $l[1] = $d1 . ($g == 'is' ? 'a' : 's');
            $l[2] = $d . 'im';
            $l[3] = $d . 'i';
            $l[4] = 'ar ' . $d . 'i';
            $l[5] = $d . 'ī';
            $l[6] = $d . ($g == 'is' ? 'i!' : '!');

        } else if ($this->deklinacija == 3) {
            $l[0] = $d . $g;
            $l[1] = $d . 'us';
            $l[2] = $d . 'um';
            $l[3] = $d . 'u';
            $l[4] = 'ar ' . $d . 'u';
            $l[5] = $d . 'ū';
            $l[6] = $d . '(us|u)!';

        } else if ($this->deklinacija == 4) {
            $l[0] = $d . $g;
            $l[1] = $d . 'as';
            $l[2] = $d . ($this->dzimte == 1 ? 'am' : 'ai');
            $l[3] = $d . 'u';
            $l[4] = 'ar ' . $d . 'u';
            $l[5] = $d . 'ā';
            $l[6] = $d . 'a!';

            $m[0] = $d . 'as';
            $m[1] = $d . 'u';
            $m[2] = $d . 'ām';
            $m[3] = $d . 'as';
            $m[4] = 'ar ' . $d . 'ām';
            $m[5] = $d . 'ās';
            $m[6] = $d . 'as!';
        } else if ($this->deklinacija == 5) {
            $l[0] = $d . $g;
            $l[1] = $d . 'es';

            if ($this->dzimte == 1) {
                $l[2] = $d . 'em';
            } else {
                $l[2] = $d . 'ei';
            }

            $l[3] = $d . 'i';
            $l[4] = 'ar ' . $d . 'i';
            $l[5] = $d . 'ē';
            $l[6] = $d . 'e!';
            if (
                !(
                    $q == 'apaļmute' ||
                    $q == 'apšaude' ||
                    $q == 'balamute' ||
                    $q == 'bāze' ||
                    $q == 'bise' ||
                    $q == 'bote' ||
                    $q == 'brīze' ||
                    $q == 'flote' ||
                    $q == 'fronte' ||
                    $q == 'gide' ||
                    $q == 'kase' ||
                    $q == 'kušete' ||
                    $q == 'mise' ||
                    $q == 'mute' ||
                    $q == 'pase' ||
                    $q == 'piešaude' ||
                    $q == 'planšete' ||
                    $q == 'rase' ||
                    $q == 'sarakste' ||
                    $q == 'šprote' ||
                    $q == 'takse' ||
                    $q == 'tirāde' ||
                    mb_substr($q, -4) == 'aste' ||
                    mb_substr($q, -2) == 'fe' ||
                    mb_substr($q, -2) == 'ģe' ||
                    mb_substr($q, -2) == 'ķe' ||
                    mb_substr($q, -4) == 'mate' ||
                    mb_substr($q, -4) == 'pēde' ||
                    (mb_substr($q, -3) == 'ste' && mb_substr($q, -4, 1) != 'k'))
            ) {
                $d1 = $this->mija($d, 5);
            } else {
                $d1 = $d;
            }

            $m[0] = $d . 'es';
            $m[1] = $d1 . 'u';
            $m[2] = $d . 'ēm';
            $m[3] = $d . 'es';
            $m[4] = 'ar ' . $d . 'ēm';
            $m[5] = $d . 'ēs';
            $m[6] = $d . 'es!';
        } else if ($this->deklinacija == 6) {
            $l[0] = $d . $g;
            $l[1] = $d . 's';
            $l[2] = $d . 'ij';
            $l[3] = $d . 'i';
            $l[4] = 'ar ' . $d . 'i';
            $l[5] = $d . 'ī';
            $l[6] = $d . 's!';

            $m[0] = $d . 'is';
            if (
                !($q == 'acs' ||
                    $q == 'aktis' ||
                    $q == 'ass' ||
                    $q == 'auss' ||
                    $q == 'balss' ||
                    $q == 'brokastis' ||
                    $q == 'Cēsis' ||
                    $q == 'dakts' ||
                    $q == 'debess' ||
                    $q == 'dzelzs' ||
                    $q == 'kūts' ||
                    $q == 'maksts' ||
                    $q == 'pirts' ||
                    $q == 'šalts' ||
                    $q == 'takts (mūzikā)' ||
                    $q == 'uts' ||
                    $q == 'uzacs' ||
                    $q == 'valsts' ||
                    $q == 'vēsts' ||
                    $q == 'zoss' ||
                    $q == 'žults')
            ) {
                $d1 = $this->mija($d, 6);
            } else {
                $d1 = $d;
            }
            $m[1] = $d1 . 'u';
            $m[2] = $d . 'īm';
            $m[3] = $d . 'is';
            $m[4] = 'ar ' . $d . 'īm';
            $m[5] = $d . 'īs';
            $m[6] = $d . 'is!';
        }
        $this->locijumi[0] = $l;
        $this->locijumi[1] = isset($m) ? $m : false;
    }

    function mija($d, $dek)
    {
        $mija[2][1] = array('b' => 'bj', 'm' => 'mj', 'p' => 'pj', 'v' => 'vj', 't' => 'š', 'd' => 'ž', 'c' => 'č', 's' => 'š', 'z' => 'ž', 'n' => 'ņ', 'l' => 'ļ');
        $mija[2][2] = array('dz' => 'dž', 'sn' => 'šņ', 'zn' => 'žņ', 'sl' => 'šļ', 'zl' => 'žļ', 'ln' => 'ļņ');

        $mija[5][1] = array('b' => 'bj', 'm' => 'mj', 'p' => 'pj', 'v' => 'vj', 'c' => 'č', 't' => 'š', 'd' => 'ž', 's' => 'š', 'z' => 'ž', 'n' => 'ņ', 'l' => 'ļ');
        $mija[5][2] = array('sn' => 'šņ', 'zn' => 'žņ', 'dz' => 'dž');
        $mija[5][3] = array('kst' => 'kp');

        $mija[6][1] = array('v' => 'vj', 't' => 'š', 'd' => 'ž', 's' => 'š', 'z' => 'ž', 'n' => 'ņ', 'l' => 'ļ');
        $mija[6][2] = array('sn' => 'šņ', 'st' => 'š');



        if (isset($mija[$dek][3]) && is_array($mija[$dek][3])) {
            $z = mb_substr($d, -2);
            reset($mija);
            while (list($key, $val) = each($mija[$dek][2])) {
                if ($key == $z)
                    return (mb_substr($d, 0, -2) . $val);
            }
        }
        $z = mb_substr($d, -2);
        reset($mija);
        while (list($key, $val) = each($mija[$dek][2])) {
            if ($key == $z)
                return (mb_substr($d, 0, -2) . $val);
        }
        $z = mb_substr($d, -1);
        reset($mija);
        while (list($key, $val) = each($mija[$dek][1])) {
            if ($key == $z)
                return (mb_substr($d, 0, -1) . $val);
        }
        return ($d);
    }

}

?>