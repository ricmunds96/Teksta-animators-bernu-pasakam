

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



--
-- Database: `pasacina`
--

-- --------------------------------------------------------

--
-- Table structure for table `fons`
--

CREATE TABLE `fons` (
  `ID_Fons` int(11) NOT NULL,
  `ID_Konts` int(11) DEFAULT NULL,
  `nosaukums` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `attels` varchar(200) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fons`
--

INSERT INTO `fons` (`ID_Fons`, `ID_Konts`, `nosaukums`, `attels`) VALUES
(1, NULL, 'mežs - diena', 'fons_mezs_diena.jpg'),
(2, NULL, 'mežs - nakts', 'fons_mezs_nakts.jpg.jpg'),
(3, 8, 'zaļā zeme', '1684420378pasakas_kartina_3.jpg'),
(5, 8, 'jaunais dzēšamais', '1684529315pasakas_kartina_3.jpg'),
(6, 8, 'jaunais dzēšamais', '1684529341pasakas_kartina_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `konts`
--

CREATE TABLE `konts` (
  `ID_konts` int(11) NOT NULL,
  `vards` varchar(50) COLLATE utf8_latvian_ci NOT NULL,
  `uzvards` varchar(50) COLLATE utf8_latvian_ci NOT NULL,
  `e_pasts` varchar(60) COLLATE utf8_latvian_ci NOT NULL,
  `parole` varchar(255) COLLATE utf8_latvian_ci NOT NULL,
  `tiesibas` bit(1) DEFAULT NULL,
  `piezimes` varchar(255) COLLATE utf8_latvian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_latvian_ci;

--
-- Dumping data for table `konts`
--

INSERT INTO `konts` (`ID_konts`, `vards`, `uzvards`, `e_pasts`, `parole`, `tiesibas`, `piezimes`) VALUES
(1, 'Testa', 'Lietotajs', 'testalietotajs@tests.com', '$2y$10$fHCJDtBRpsJn0Ux1rnUBUe7YflE4znhzt3yVMpfUug8ydlfNMDmn2', b'1', NULL),
(2, 'Peteris', 'Cirksiss', 'peteris@te.te', '$2y$10$Vm1yxIXfnrixRLIoJywuGuaQvAFo4HsbMj2kGD6Qnu3oO35N1vCdG', b'0', NULL),
(3, 'TeTer', 'TetEe', 'te@te.te', '$2y$10$8LPcR539W/ASW2xrzjowsOcQnRgXGBhoJSJAhZvgFINVzxxdZDH8K', NULL, NULL),
(4, 'Ginters', 'Papapa', 'garais@epasts.lv', '$2y$10$9r5N1IT6KWQmG8tq6agI6udn0xPf8fpgL/WJHcHAV7YB.LvZEe9ZS', NULL, NULL),
(5, 'Vards', 'Uzvards', 'admin@te.te', '$2y$10$Vm1yxIXfnrixRLIoJywuGuaQvAFo4HsbMj2kGD6Qnu3oO35N1vCdG', b'1', NULL),
(6, 'Pēteris', 'ČirkšisC', 'peco@peco.lv', '$2y$10$5L4l6qYM92nRDUA/xAvXruD2w6pQ3nDv6xqSSfq7jx226MUid2fO6', b'1', NULL),
(8, 'Jauns', 'Jaunss', 'jauns@jauns.jauns', '$2y$10$jPcjfvb1bFUStPV.r9bnAuEhgulygxdSQGUBtM1Ddi/H8j6yFNdMu', NULL, NULL),
(9, 'Easdas', 'Uasdasd', '11@11.aa', '$2y$10$5JVnDRcIyh.KT.MVkUTxa.ysulSa35vo7WfGr5HSpW2Ro2M2bJtqu', NULL, NULL),
(10, '111!sS', 'Ee', 'Ee@Ee.Ee', '$2y$10$uu73cJlsMrOuRSX7nN1OdebvqYfY2SmAMBCj.SOWZf6MM4apbPbEa', NULL, NULL),
(11, 'Peco', 'Akmens', 'peco@akmens.lv', '$2y$10$o6mtivLcQIOMsY/oE3xRPuxAWDWaI2D02KeAB6wDPwv6CH.lVMKTC', NULL, NULL),
(12, 'Jauns', 'Lietotajs', 'jauns@lietotajs.lvv', '$2y$10$wCgMxeaQOqEINl4x0J4kQu2ib.bnI/krQLMuBDQHFM2Eq5F24FvrS', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pasaka`
--

CREATE TABLE `pasaka` (
  `ID_pasaka` int(11) NOT NULL,
  `nosaukums` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `apraksts` varchar(500) CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `pasaka` mediumtext CHARACTER SET utf8 COLLATE utf8_latvian_ci DEFAULT NULL,
  `ID_konts` int(11) DEFAULT NULL,
  `attels` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasaka`
--

INSERT INTO `pasaka` (`ID_pasaka`, `nosaukums`, `apraksts`, `pasaka`, `ID_konts`, `attels`) VALUES
(1, 'Ansītis un Grietiņa.', 'Jākobs Grimms, Vilhelms Grimms - Ansītis un Grietiņa. Brāļu Grimmu populārā pasaka ar mākslinieces Anitas Ozoliņas izteiksmīgajiem zīmējumiem par diviem bērniem Ansīti un Grietiņu un ļauno raganu.', 'Vienam vīram nomirusi sieva un palikuši divi bēni: puika un meitene. Puikam bīš Ancītis vārdā, meitenei Grietīna. Vīrs apprecēš otru sievu, un pamātei bēni nepatikuši. Šī nu vienmēr vīram dindināsi, lai ved bēnus uz mežu, jo no tiem nekāda labuma neesot. Vīrs gan negribēš, gan negribēš, bet ka sieva šim nelikusi ne dienu, ne nakti miera, tā pēdīgi ar nospriedis, ka jāvedot vie būšot. Nu tēvs sacīš Ancīšam un Grietiņai, ka lai sataisās, iešot rītīnā agri uz mežu. Šis cirtīšot malku, šie (bērni) varēšot tikmēr ogas palasīt. Rītīnā tēvs bīš jau agri augšā un taisījies uz mežu. Viņč aicināš Ancīti un Grietīņu līdz. Visi nu gāši uz mežu. Pa ceļam Ancītis lasīš akmintīnus un bāzis ķešā. Ka nu šie visi iegāši mežā, ta Ancīc tik pa vienam vie akmentīnam sviedis zemē un visī trīs tik gāši dziļāk mežā iekša. Ka nu bīši jau labi dziļi iegāši mežā iekšā, tā tēvs sacīš uz bēniem, lai šie tepatēm paliekot un palasot ogas, šis paiešoties tālāk un tur cirtīšot malku. Ancītis ar Grietīņu palikuši tepatēm un lasīši ogas, bet tēvs pagāš gabalīnu tālāk un cirtis, ka skanēš vie. Bēni lasīši, lasīši ogas, kamēr pienācis vakars, bet tēvs, kā nenācis, tā nenācis. Nu bēni gāši uz to pusi, kur tēvs cirtis. Ka nu piegāši klā, tā tik redzēši, ka tēva nemaz nav, bet tik vējā klabinās vāle, kas bīsi pie egles piesieta. (Tēvs jau tūlītās aizgāš uz māju un piesēš vāli pie egles, lai tā vējā klabinās un bēni domā, ka šis cērt malku). Kot\' nu darīt? Bēni gudroši, gudroši un pēdīgi Ancītis atminējies, ka pa ceļu mētājis akmintīnus. Nu šie tik gāši un meklēši akmentīnus rokā. Tā gāši, gāši kamēr iznākuši uz ceļa un bīši aka mājā iekšā. Pamāte tos saņēmusi mīļi un labi. (Šī bīsi traki viltīga, tik aiz muguras ļaunu par visiem runāsi, bet priekšā ne čiku, ne grabu). Tēvs ar bīš traki priecīgs, ka bēni aka mājā. Tā nu aka visi dzīvāši. Bet pamāte nelikusi vīram miera un vienmēr didināsi, lai ved bēnus prom uz mežu. Gan vīrs negribēš, gan negribēš, bet nekā ar pēdīgi nedabūš miera. Nu viņš aka vienā rītīnā aizvedis bēnus uz mežu un atstāš mežā. Bet Ancītis aka pa ceļu salasīš akmintīnus un ka iegāši mežā, tā tas aka izmētāš un vakarā aka pa izmētātiem akmintīniem abi bēni atnākuši atpakaļ. Pamāte aka bīsi ļoti laimīga, ka bēni mājā, bet bēniem aiz muguras kritusi vīram virsū, ka šīs tāds muļļa vie esot, ka nevarot bēnus ievest labi dziļi mežā iekšā. Neko darīt un vīrs drīz vie aka vedis bēnus uz mežu un nu vedis tālu tālu mežā iekšā. Gan Ancītis metis akmentīnus zemē, bet pēdīgi to aptrūcis, tā viņš sācis drupināt no maizes rika, ko tam pamāte iedevusi, un kaisīš druscīnas zemē. Ka nu iegāš aka dziļi mežā iekšā, tā tēvs sacīš uz bēniem, lai šie tepatēm palasoties ogas, šis iešot tālāk un cirtīšot malku. Ancītis un Grietīna palikuši un tēvs aizgāš tālāk, aka piesēš pie egles vāli un to vēš klaudzināš. Ka pienācis vakars un bērni nevarēši tēva sagaidīt, tā tie gāši uz to pusi, kur vāle vējā klabēsi, bet ko nu, ne tēva, ne kā! Nu bēni sākuši meklēt ceļu uz māju. Izmeklēšies, izmeklēšies, bet nekā nevarēši atrast. Putni pa dienu bīši salasīši druscīnas, kuras Ancīc no maizes rika drupināš un kaisīs zemē. Tā ar abi bēni netikuši vais no meža ārā. Nu Ancītis un Grietīna ilgi maldīšies pa mežu un ārā netikuši. Nakts nākusi virsū un pietrūcies arī ēst. Tikmē abi maldīšies, kamē pienākuši pie mazas majīnas un tai jumts bīš no pīrēgiem un sienas no sukura. Nu Ancītis ar Grietīnu sākuši tik skrubināt no jumta un sienām, bāzuši tik mutē un ēduši. Drīz vien no mājīnas iznākusi veca, salīkusi vecene un prasīsi, kas tur grabinoties? Bēni atbildēši, ka tie esot šie - Ancītis un Grietīna. Nu vecene aka prasīsi, kā tā šie te esot tikuši? Nu Ancīc ar Grietīnu visu izstāstīši. Ka tā, ta vecene sacīsi, lai nākot mājīnā iekšā. Ancītis ar Grietīnu gāši mājīnā iekšā. Vecene Grietīnu pieņēmusi par mājīnas apkopēju un Ancīti tūlitan ielikusi aizgaldā un sākusi barot. Aizgaldā bīš tāds caurums un pa to katru nedēļu bīš Ancīšam jāizbāš mazais pirkstīc un vecene - tā bīsi ragana - aplūkāsi, vai tas jau esot dau[dz] resnāks. Pirmo nedēļu Ancītis pa caurumu izbāsis mazo pirkstīnu un otru nedēļu ar darīš tāpatēm. Bet ta viņč apķēries, sak\', uz labu tāda barošana nau, jo ragana bīsi traki priecīga, ka šis pa to laicīnu esot dau brengāks palīcies. Bet nu Ancīts nozīdis mazo pirkstīnu, kamē tas pavisam kaulains palicis un tā bāzis to raganai. Vecene bīsi traki errīga, ka šo nobarot vie nevarot. Tā nu tas gāš labu laicīnu, Ancītis arvienu vē nozīdis savu mazo pirkstīnu un to vienmēr grūdis caurumā, ka vecene prasīsi, lai parāda. Pēdīgi vecene noskaitusies un likusi Grietīnai nokurināt makten karstu krāsni. Ka krāsns bīsi nokurēsies, tā vecene likusi Grietīnai, lai bāžot galvu līdz pleciem krāsnī iekšā un paprovējot, vai krāsns esot īsten nokurināta. Bet Grietīna vis nebīsi duma. Šī vis nebāzusi galvu krāsnī, bet sacīsi, ka nemākot un nemākot. Nu vecene noskaitusies un pieskrēsi pie krāsns un grūdusi galvu iekšā. Tiklīdz vecene iegrūdusi galvu krāsnī, ka Grietīna tūlitam saķērusi veceni aiz kājām un iegrūdusi krāsnī iekšā un vecene izcepusi, ka nočaukstēsies vie. Tagadīt nu Grietīna skrēsi pie Ancīša un izlaidusi to no aizgaldas. Nu ragana bīsi pagalam. Ancītis ar Grietīnu palikuši tur patem - sukura un pīrēgu mājīnā un dzīvoši laimīgi.', 8, 'pasakas_kartina_1.jpg'),
(2, 'Velns gaida parādu ', NULL, 'Zemnieks, pa ceļu iedams, nokūst un atsēstas ceļmalā uz liela akmeņa atpūsties. Atnāk velns un uzkliedz: «Kā tu drīksti uz mana krēsla sēdēt?»\n\n\nZemnieks atbild droši: «Ko tu kliedz? Vai tu gribi, lai es tevi par putekļiem saberžu?»\n\nVelnam jau metas bailes, un viņš nu runā mierīgā balsī: «Kas tev no tā par labumu būs?»\n\n«Labums būs tas, ka es varēšu mierīgi sēdēt un atpūsties.»\n\n«Kur tu tā iedams?»\n\n«Biju pie drauga naudas aizjemties, bet neatradu mājā.»\n\n«Ja tu būsi ar mani labs, tad es varu tev naudu aizdot.»\n\n«Labi, dod tik šurpu!»\n\n«Bet rudeni, kad kokiem nobirst lapas, tu man atkal šepat atnes to naudu!»\n\n«Labi, esmu ar mieru.»\n\nVelns nu atnes zemniekam lielu maisu naudas, un tas, saņēmis naudu, iet mierīgi uz māju. Atnāk jau rudens, bet zemnieks nemaz nedomā par savu parādu. Velns gaida, gaida, bet zemnieks kā nenāk, tā nenāk. Ziemā zemniekam iznāk atkal braukt pa to pašu ceļu uz savu draugu. Piebraucot pie lielā akmeņa, nāk viņam velns pretī un saka: «Laiks jau ir sen pagājis, bet tu man vēl neesi savu parādu aizmaksājis.»\n\nZemnieks atbild: «Gaidi, kad būs laiks, tad es savu parādu samaksāšu.»\n\n«Bet kokiem jau sen ir lapas nobirušas.»\n\n«Egles un priedes ir tomēr vēl zaļas.»\n\nTā nu velns gaida vēl šodien, kad arī eglēm un priedēm nobirs skujas, lai varētu dabūt savu naudu atpakaļ.', 7, 'pasakas_kartina_2.jpg'),
(6, 'Noburtā līgava', 'Kādam tēvam bij trīs dēli: divi gudri, viens muļķis. Kādu dienu tēvs saka dēliem: “Pie manis nekā nepelniet, eita pasaulē kaut ko nopelnīt!”', 'Visi trīs aiziet. Mežā pie kāda ozola tie domā izšķirties un tādēļ norunā tā: “Iekams šķiramies, iedursim šinī ozolā katrs savu nazi. Ja kāds no mums ātrāki pārnāktu, tad lai naži pateic, kā abiem brāļiem svešumā klājies – ja naži spoži – tad labi, ja norūsējuši – tad nelabi.”\\\\r\\\\n\\\\r\\\\nGudrie nu aiziet viens uz ziemeļiem, otrs uz rītiem, muļķītis uz dienvidiem. Trešā dienā, caur mežu ejot, muļķītis satiek zaķi. satiek stirnu, visbeidzot satiek arī lāci. Zaķis grib aizlēkt, stirna grib aizbēgt un lācis grib virsū skriet; bet muļķītis viņus visu trīs pielabina sev par ceļa biedriem. Un tā bij viņa laime; jo drīzi vien viss mežs aizklimst: deviņdesmit un deviņi vilki dzenas pakaļ. To dzirdot lācis saka uz muļķīti: “Sēdies man mugurā, es tevi izglābšu.”\\\\r\\\\n\\\\r\\\\nMuļķītis sēžas mugurā un nu iet: zaķītis pa priekšu, tekas meklēdams, stirna nopakaļu, zarus no ceļa līdzinādama un lācis ar muļķīti pa iemītām pēdām klātu vien, klātu vien. Tā tie jož gabalu lielo, kamēr lācis, pie beigām nokusis, apstājas, sacīdams: “Ko vēl skriet, tiem pēdas nojukušas. Nu, manu jātniek, vai negribas ēst?”\\\\r\\\\n“Kā nu negribēsies, lācīti mīļais, bet kur lai ņem?”\\\\r\\\\n\\\\r\\\\n“Pagaidi – dabūšu!”\\\\r\\\\n\\\\r\\\\nLācis ieiet dziļāki mežā un iznes medu. Šie nu abi sukā medu; zaķītis, stirna vicojas gar lapām, atvasēm.\\\\r\\\\nPaēdis, muļķītis iet tālāk un atron dziļi mežā skaistu, skaistu pili. Ieiet pilī – neviena cilvēka; tik cilvēka galva nolikta pagaldē. Izskatās – iet atkal ārā; bet galva sauc atpakaļ, prasīdama: “Puisīt, no kurienes esi, ko meklē?”\\\\r\\\\nMuļķītis izstāsta visu, no kurienes nācis un ko mežā, no vilkiem bēgdams, piedzīvojis.\\\\r\\\\n\\\\r\\\\n“Jā, redzi, puisīt, šie deviņdesmitdeviņi vilki, mūs burdami, nobūrās arī paši sevi. Tas bija tā: šis mežs senāk bija mana ķēniņa valsts un viņi – vilki – deviņdesmit deviņi burvji. Burvji, atnākdami pār deviņām jūrām, gribēja visu manu valsti noburt; bet burdami aizmirsa, ka visu valsti burot, paši sev arī līdz nobursies, tādēļ ka tai brīdi paši arī manā valstī atradās. Tā arī notika: es paliku par galvu, mana meita ar pavalstniekiem par meža zvēriem un šie par vilkiem. Tomēr, ja kāds mani trīs rītus, saulītei lecot, aiznestu pie svētās akas mazgāt, tad paliktu ir es, ir mani pavalstnieki par cilvēkiem. Bet glābējam tas nav tik viegli darāms, jo, kad mani nesīs, tad visādi zvēri, putni aiz muguras kritīs virsū, brēks, kliegs, kauks. Tomēr, ja tik nociešas, atpakaļ neskatās; tad zvēri nedrīkst ne vīlītes aiztikt un mēs esam glābti.”\\\\r\\\\n\\\\r\\\\nMuļķītis apņemas to izdarīt un – par laimi – arī izdara. Trešā rītā bij lieli prieki pilī: galva paliek par ķēniņu, stirna par viņa meitu, lācis par ķēniņa tēvu, zaķītis par ķēniņa dārznieku un citi meža zvēri par ķēniņa pavalstniekiem. Tik vilki – vilki bijuši, vilki palika. Ķēniņš nu atdeva savu meitu muļķītim par sievu un pieņēma to par savu mantinieku. Tās bij kāzas, kādas nekur nav redzēts. Arī muļķīša tēvs un abi brāļi ieradās kāzās un palika pilī dzīvot.', 8, '16852935462009072413361744365_o-696x464.jpg'),
(14, 'Sadancotās kurpes', 'Reiz dzīvoja ķēniņš.....', 'Reiz dzīvoja ķēniņš, tam bija trīs meitas, kas ik naktis noplēsa pāri zābaku. Ķēniņš, nevarēdams saprast, kā tas gadās, sūtīja zaldātus ķēniņa meitas pa nakti sargāt. Pagāja viena nakts, otra – visi ķēniņa meitu sargi pazaudēja dzīvības, jo ķēniņš bija pavēlējis visus nosodīt, kas nenosargās.\\\\r\\\\n\\\\r\\\\nReiz kādu vakaru atkal viens zaldāts gāja pie ķēniņa meitām. Gāja raudādams. Ceļā to satika viens vecītis un vaicāja: “Kāpēc raudi?”\\\\r\\\\nViņš izstāstīja savas bēdas. Vecītis – tas bijis pats Dievs – mierināja: “Nebīsties, es tev došu padomu, kā jāsarga. Tiklīdz ieiesi meitu istabā, tad ķēniņa meitas tev dos izdzert biķeri vīna. Bet tu nedzer, paņem pieliec pie lūpām un lej, lai aiztek tev gar drēbēm. Vīnā būs iemidzināmās zāles. Liecies gulēt pēc tam, bet neaizmiedz. Turklāt tev piešķiršu tādu sevišķu spēku, ka neviens tevi lai nesaredzētu. Bet ja ķēniņa meitu istabā iznāktu trīs jaunskungi ar ragiem pierē – tie būs velli – tad nesabaidies, seko droši tiem, ja viņi ar ķēniņa meitām no istabas laukā iet, jo tu būsi tiem nesaredzams. Ceļā tai uzmin uz drēbēm, kas nopakaļus ies. Ja, un tā viņi visi aizies uz vellu mājokli, sāks tur dzīrot, līksmoties, bet ap dzīras beigām tiecies pēc tiem traukiem, no kuriem ķēniņa meitas dzērušas. Papriekšu paņem jaunākās meitas trauku, pēc tam vidējās, beidzot vecākās. Tad, kamēr viņi tur dej un līksmojas, paņem nūju, iedur sētas vidū, lai otrā rītā vari to vietu uzzīmēt.”\\\\r\\\\n\\\\r\\\\nKad nu zaldāts iegāja istabā, ķēniņa meitas viņam sniedza biķeri vīna. Bet zaldāts darīja, kā vecītis mānīja, aizlēja vīnu sev gar drēbēm. Pēc tam likās gulēt un izlikās par aizmigušu. Nu atnāca trīs kungi ar ragiem, laipni sasveicinādamies ar ķēniņa meitām. Tad visi devās laukā, aiziedami uz vellu mājokli. Zaldāts piecēlās, gāja pakaļ, arvienu tai ķēniņa meitai uzmīdams uz drēbēm, kas nopakaļus gāja. Šī vienreiz paskatās atpakaļ; otrreiz – beidzot teiks: “Viens man drānas piemina, bet nevaru nekā ieraudzīt.”\\\\r\\\\n\\\\r\\\\nTā viņi nogāja pie velliem ļoti lepnā namā. Še raganie velli pārvērtās par vācu dzimtskungiem un iesāka trakulīgi diet un dzīvot. Zaldāts visu redz, šie zaldāta neredz. Izdējušies un izdzīvojušies apnikdami sāka viņu dzert. Te piepēži nozūd dzeramie trauki. Ķēniņa meitas aplam izbijās un jaunākā iebilst: “Nebūs labi!”\\\\r\\\\n\\\\r\\\\nTomēr apmierinājās atkal, kad ierunājās, ka neviena sveša te neesot namā. Bet zaldāts, iedūris nūju pagalmā, pārsteidzās uz māju, uz savu sargājamo vietu un gulēja cietā miegā. Pārnāks ķēniņa meitas, atron zaldātu guļam, sāks šīs apmierināties teikdamas: “Izgulies, izgulies, galviņ, gan rītu novelsies no pleciem!”\\\\r\\\\n\\\\r\\\\nTiklīdz gaismiņa ausa, ķēniņš atsūta savu sūtni, lai zaldāts nākot pie viņa! Bet zaldāts tikai guļ, nelikdamies gar sūtni ne zinot. Ķēniņš sūta otru sūtni, cieši pavēlēdams, lai tūliņ zaldāts būtu nācis pie viņa, bet zaldāts negāja. Trešo lāgu atnāks ķēniņš pats, vēlēdamies zaldātu vai uz vietas nonāvēt.\\\\r\\\\n\\\\r\\\\nPiegājis pie zaldāta gultas, tas uzkliedza: “Ko? Vai tā nosargāji?”\\\\r\\\\nZaldāts mierīgā balsī atbild: “Nosargāju gan!” Ķēniņš nepacietībā vaicā: “Nu, kur tad viņas bija?”\\\\r\\\\nZaldāts atbild: “Lepnā dimanta namā, tur tās dzīroja un deja cauru nakti.”\\\\r\\\\nĶēniņš vaicā: “Vai nevari man to namu parādīt’?”\\\\r\\\\nZaldāts aizved ķēniņu pie liela akmeņa. Kad akmeni novēla, atrada lielu namu un nama pagalmā zaldāta nūju iedurtu.\\\\r\\\\nĶēniņš pārgāja pie savām meitām un vaicāja: “Kur jūs bijāt izgājušo nakti?”\\\\r\\\\nŠīs atsaka: “Mājā bijām!”\\\\r\\\\n\\\\r\\\\nTad zaldāts izņēma no kabatas tos traukus, no kuriem šīs naktī kopā ar velniem bija dzērušas. Uz katra trauka bija vienas ķēniņa meitas vārds. Tagad meitas vairs nevarēja savu noziedzību slēpt, izteicās smalki kā bijis. Nu ataicināja trejdeviņus mācītājus un tad no tā laika velli izzuda tai valstī.\\\\r\\\\nĶēniņš atdeva jaunāko meitu zaldātam par sievu un pūrā iedeva līdz pusvalsti.\\\\r\\\\n\\\\r\\\\n', 8, '1685293701kurpes1.jpg'),
(24, 'Velns gaida parādu', 'Zemnieks, pa ceļu iedams, nokūst un atsēstas ceļmalā uz liela akmeņa atpūsties. Atnāk velns un uzkliedz: Kā tu drīksti uz mana krēsla sēdēt?', 'Zemnieks pa ceļu iedams nokūst un atsēstas ceļmalā uz liela akmeņa atpūsties. Atnāk velns un uzkliedz Kā tu drīksti uz mana krēsla sēdēt.rnrnZemnieks atbild droši Ko tu kliedz. Vai tu gribi lai es tevi par putekļiem saberžu.rnrnVelnam jau metas bailes un viņš nu runā mierīgā balsī Kas tev no tā par labumu būs.rnrnLabums būs tas ka es varēšu mierīgi sēdēt un atpūsties.rnrnKur tu tā iedams.rnrnBiju pie drauga naudas aizjemties bet neatradu mājā.rnrnJa tu būsi ar mani labs tad es varu tev naudu aizdot.rnrnLabi dod tik šurpu.rnrnBet rudeni kad kokiem nobirst lapas tu man atkal šepat atnes to naudu.rnrnLabi esmu ar mieru.rnrnVelns nu atnes zemniekam lielu maisu naudas un tas saņēmis naudu iet mierīgi uz māju. Atnāk jau rudens bet zemnieks nemaz nedomā par savu parādu. Velns gaida gaida bet zemnieks kā nenāk tā nenāk. Ziemā zemniekam iznāk atkal braukt pa to pašu ceļu uz savu draugu. Piebraucot pie lielā akmeņa nāk viņam velns pretī un saka Laiks jau ir sen pagājis bet tu man vēl neesi savu parādu aizmaksājis.rnrnZemnieks atbild Gaidi kad būs laiks tad es savu parādu samaksāšu.rnrnBet kokiem jau sen ir lapas nobirušas.rnrnEgles un priedes ir tomēr vēl zaļas.rnrnTā nu velns gaida vēl šodien kad arī eglēm un priedēm nobirs skujas lai varētu dabūt savu naudu atpakaļ.', 8, '16852949171685293153231232.jpg'),
(25, 'Kalējs Reins', 'Vecos laikos dzīvoja kāds godīgs kalējs, Reins vārdā, kuru dievs bija svētījis ar lielu bērnu pulciņu un kuram tādēļ bija cītīgi jāstrādā, lai savējiem varētu pārtiku sagādāt. Tādēļ ka viņš savā amatā bija sapratīgs un apzinīgs, viņam nekad netrūka darba un peļņas. No agra rīta līdz vēlam vakaram viņa smēdē dzirdēja zem vesera sitieniem dzelzi skanot.', 'Vecos laikos dzīvoja kāds godīgs kalējs Reins vārdā kuru dievs bija svētījis ar lielu bērnu pulciņu un kuram tādēļ bija cītīgi jāstrādā lai savējiem varētu pārtiku sagādāt. Tādēļ ka viņš savā amatā bija sapratīgs un apzinīgs viņam nekad netrūka darba un peļņas. No agra rīta līdz vēlam vakaram viņa smēdē dzirdēja zem vesera sitieniem dzelzi skanot.rnrnBet tad piepēši kalējam Reinam sāka klāties plāni. Darba devēji cits pēc cita no viņa atrāvās un gāja pie viena sveša kalēja kas arī turpat tuvumā bija uzcēlis savu smēdi un strādāja par tik lētu maksu par kādu neviens kalējs nevarēja pastāvēt un dažam labam kala pat gluži par brīvu. Svešais kalējs kā rādījās negribēja vis ar savu darbu nopelnīt pārtiku bet tikai Reinam atņemt darbu. Kaut gan svešajam kalējam darba bija ļoti daudz tomēr viņš visu paguva pa dienu tikai dažus brīžus strādādams. Par saviem darbiem viņš pelnīja ļoti maz tādēļ ka kala pārliecīgi lēti bet naudas un mantas viņam bija papilnam. Daži sāka domāt ka viņš stāvot sakarā ar pašu nelabo kas viņam palīdzot.rnrnKalējam Reinam drīz vien pienāca pilnīgs darba trūkums un bads. Vienu dienu viņš atkal stāvēja savā smēdē gluži izmisis bez darba un raizējās par to kā savējus varētu izglābt no bada.rnrnEs savu dvēseli pārdotu velnam ja tikai savu sievu un bērnus varētu izglābt no trūkuma. viņš nopūzdamies izsaucās un patlaban taisījās aizslēgt smēdi. Ja dievs par mani neapžēlojas tad lai velns man palīdz.rnrnTad uzreiz ienāca smēdē viens melns kungs kuram viena kāja izskatījās kā zirga un otra kā gaiļa kāja.rnrnTu vēlējies lai tev palīdzu. viņš uzrunāja kalēju Reinu un še es esmu. Es tev palīdzēšu iegūt daudz darba un bagātības ja pārdosi man savu dvēseli.rnrnNo iesākuma kalējs Reins bija ļoti iztrūcies bet kad svešais kungs viņam laipni paskaidroja ka tad kad kalējs ar viņu taisītu līgumu viņš nāktu pēc tā dvēseles tikai pēc desmit gadiem un pa visu šo laiku tas varētu dzīvot pēc savas patikšanas un krāt savējiem bagātību jo viņš izpildīšot katru kalēja vēlēšanos un nesīšot tam arī naudu cik vien prasīšot .. tad ari kalējs apņēmās pārdot velnam savu dvēseli. Melnais kungs tam pavēlēja ar naglas galu drusku pārdurt kreisās rokas stilba asins dzīslu un tad ar kalēja asinīm turpat norakstīja līgumu kuru kalējs parakstīja.rnrnTagad varēsi dzīvot bez raizēm. melnais kungs sacīja un tūliņ iedeva kalējam lielu maku pilnu ar naudu. Darba tev būs papilnam un viss tev brīnišķi veiksies. Kad tev kas būs vajadzīgs tad tikai pasauc mani .. un es tev visu apgādāšu. Ar šiem vārdiem melnais kungs piepēši pazuda.rnrnKalējam Reinam nebija vis labi ap dūšu kad atkal bija palicis vienatnē. Bet apskatīdams dabūto smago naudas maku viņš drīz vien apmierinājās jo tagad viņa dzimta bija glābta no bada. Viņš apņēmās ne sievai ne bērniem nestāstīt kas bija noticis lai viņus par velti neskumdinātu. Un desmit gadi bija arī vēl ilgs laiks ko dzīvot.rnrnSvešais kalējs kas Reinam bija noņēmis darbu bija piepēši aizgājis un savu smēdi noplēsis. Reinam nu atkal bija ļoti daudz darba un kalšana tam arī patiesi brīnišķi veicās. Visā apkārtnē viņu slavēja par krietnu kalēju.rnrnKalēja Reina dievbijīgā sieva pateicās dievam par tādu negaidītu svētību bet pašam kalējam sirds tapa vienmēr smagāka jo gadi ātri pagāja un vienmēr vairāk tuvojās tas laiks kur viņam dvēsele jāatdod ļaunajam.rnrnSmēdē kaldams viņš pastāvīgi žēlojās un lūdza dievu lai viņam palīdzētu no velna vaļā tikt un glābt savu dvēseli bet nevarēja apmierināt savu sirdi. Pēdīgi desmit gadi jau bija pagājuši kad velns piebrauca ar diviem melniem zirgiem pie kalēja smēdes un sacīja Nu ir laiks klāt brauc man līdz.rnrnNeko darīt līgums jāizpilda. Reins atbildēja izrādīdamies gluži mierīgs un padevīgs. Bet iesim vēl apskatīt manu ābeļu dārzu.rnrnNu abi aizgāja uz ābeļu dārzu. Reins rādīja velnam vienu ābeli kuras augšējos zaros bija lieli sārti āboli. Sai ābelei ir ļoti gardi āboli. viņš piebilda.rnrnVai es nevarētu kādu pabaudīt. velns jautāja.rnrnKādē ne. Reins atbildēja. Uzkāp tikai pats ābelē un ņem cik patīk.rnrnVelns uzkāpa ābelē bet Reins tūliņ nometās pie ābeles ceļos aizmeta krustu un sāka lūgt dievu lai atpestītu viņu no ļaunā.rnrnRein Rein laid mani zemē nekavē manis. velns no augšas izbijies sauca.rnrnJa man vēl atļauj desmit gadu dzīvot tad laidīšu zemē. Reins atbildēja vēl arvien dievu lūgdams.rnrnApsolu vēl tev desmit gadu tikai laid mani projām. velns lūgdamies sauca.rnrnReins piecēlās un priecājās ka bija izdevies vēl uz desmit gadiem Izglābties no elles mokām. Velns nokāpa no ābeles un aizbrauca viens pats dusmīgs projām.rnrnOtri desmit gadi jau taisījās uz beigām kad Reinam atkal uznāca raizes par savu dvēseli. Viņš uzkala apaļu dzelzs bumbu ar tukšu vidu un vienu mazu caurumiņu. Noteiktā laikā melnais kungs atkal piebrauca ar četriem melniem zirgiem pie kalēja smēdes un uzsauca tam bargi Nu tev jābrauc man līdz ilgāki vairs neļaušu dzīvot.rnrnTo jau zinu un tādēļ arī esmu sataisījies atstāt šo pasauli. Reins atbildēja gludinādams savu bumbu.rnrnKam tu šo bumbu taisīji.rnrnTas ir mana tēva darbs kurš ari bija kalējs. Reins melojās. Es to gribēju ņemt līdz par piemiņu no tēva. Mans tēvs varēja šai bumbā pat ielīst.rnrnEs ari varētu tai bumbā ielīst. velns piebilda.rnrnEs to neticu. Reins atbildēja.rnrnVelns piepēši savilkās ļoti mazs un ielīda bumbā. To tikai Reins bija gaidījis. Viņam jau stāvēja pie rokas veseris un nagla kuru viņš steigšus iedzina bumbas caurumā tad iemeta bumbu kvēlošās oglēs plēšu priekšā un sāka pūst. Kad bumba bija nodegusi sarkana tad paņēma to lielajās stangās uzlika uz laktas un sāka kalt. Velns bumbā gan dikti pīkstēja bet Reins tikmēr kala bumbu kamēr tā palika pavisam plakana un pīkstēšana apklusa. Tad viņš pārcirta bumbu un no tās izšāvās zila smirdoša liesma kas nejauki sprēgādama izskrēja pa smēdes durvīm ārā. Arī velna zirgi ar visiem ratiem bija pazuduši no smēdes priekšas.rnrnTā kalējs izglāba savu dvēseli no velna varas.', 8, '16852963361685291414111111.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pasaka_fons`
--

CREATE TABLE `pasaka_fons` (
  `ID_Pasaka` int(11) NOT NULL,
  `ID_Fons` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasaka_fons`
--

INSERT INTO `pasaka_fons` (`ID_Pasaka`, `ID_Fons`) VALUES
(1, 1),
(1, 2),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `pasaka_vards`
--

CREATE TABLE `pasaka_vards` (
  `ID_Pasaka` int(11) NOT NULL,
  `ID_Vards` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasaka_vards`
--

INSERT INTO `pasaka_vards` (`ID_Pasaka`, `ID_Vards`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vards`
--

CREATE TABLE `vards` (
  `ID_Vards` int(11) NOT NULL,
  `ID_konts` int(11) DEFAULT NULL,
  `nom` varchar(50) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `gen` varchar(50) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `dat` varchar(50) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `aku` varchar(50) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `lok` varchar(50) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `vok` varchar(50) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL,
  `attels` varchar(100) CHARACTER SET utf8 COLLATE utf8_latvian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vards`
--

INSERT INTO `vards` (`ID_Vards`, `ID_konts`, `nom`, `gen`, `dat`, `aku`, `lok`, `vok`, `attels`) VALUES
(1, NULL, 'kaķis', 'kaķa', 'kaķim', 'kaķi', 'kaķī', 'kaķi', 'cat.jpg'),
(2, NULL, 'Vīrs', 'vīra', 'vīram', 'vīru', 'vīrā', 'vīrs', 'virs.png'),
(3, NULL, 'sieva', 'sievas', 'sievai', 'sievu', 'sievā', 'siev', 'woman.png'),
(4, 8, 'puika', 'puikas', 'puikam', 'puiku', 'puikā', 'puika', 'ansitis.png'),
(5, 8, 'meitene', 'meitenes', 'meitenei', 'meiteni', 'meitenē', 'meitene', 'grietina.png'),
(6, 8, 'vīrs', 'vīra', 'vīram', 'vīru', 'vīrā', 'vīrs', '1683931970gie5B478T.png'),
(9, NULL, 'nomirusi', 'nomirusi', 'nomirusi', 'nomirusi', 'nomirusi', 'nomirusi', '1683932762gie5B478T.png'),
(10, 11, 'sdadassda', 'sdadassdas', 'sdadassdam', 'sdadassdu', 'sdadassdā', 'sdadassda!', '1684413782gie5B478T.png'),
(11, 8, 'sieva', 'sievas', 'sievai', 'sievu', 'sievā', 'sieva!', '1684415585woman.png'),
(12, 8, 'sieva', 'sievas', 'sievai', 'sievu', 'sievā', 'sieva!', '1684416511woman.png'),
(14, 8, 'sieva', 'sievas', 'sievai', 'sievu', 'sievā', 'sieva!', '1684416511woman.png'),
(15, 8, 'grietīna', 'grietīnas', 'grietīnai', 'grietīnu', 'grietīnā', 'grietīna!', '1684697268grietina.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fons`
--
ALTER TABLE `fons`
  ADD PRIMARY KEY (`ID_Fons`);

--
-- Indexes for table `konts`
--
ALTER TABLE `konts`
  ADD PRIMARY KEY (`ID_konts`);

--
-- Indexes for table `pasaka`
--
ALTER TABLE `pasaka`
  ADD PRIMARY KEY (`ID_pasaka`);

--
-- Indexes for table `pasaka_fons`
--
ALTER TABLE `pasaka_fons`
  ADD PRIMARY KEY (`ID_Pasaka`,`ID_Fons`);

--
-- Indexes for table `pasaka_vards`
--
ALTER TABLE `pasaka_vards`
  ADD PRIMARY KEY (`ID_Pasaka`,`ID_Vards`);

--
-- Indexes for table `vards`
--
ALTER TABLE `vards`
  ADD PRIMARY KEY (`ID_Vards`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fons`
--
ALTER TABLE `fons`
  MODIFY `ID_Fons` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `konts`
--
ALTER TABLE `konts`
  MODIFY `ID_konts` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pasaka`
--
ALTER TABLE `pasaka`
  MODIFY `ID_pasaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `vards`
--
ALTER TABLE `vards`
  MODIFY `ID_Vards` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;
