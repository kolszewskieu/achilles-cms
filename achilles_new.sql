-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 19 Mar 2013, 13:10
-- Wersja serwera: 5.1.66
-- Wersja PHP: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `achilles_new`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `branze`
--

CREATE TABLE IF NOT EXISTS `branze` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa_pl` varchar(256) NOT NULL,
  `nazwa_en` varchar(256) NOT NULL,
  `nazwa_se` varchar(256) NOT NULL,
  `nazwa_no` varchar(256) NOT NULL,
  `widoczna_pl` enum('tak','nie') NOT NULL,
  `widoczna_en` enum('tak','nie') NOT NULL,
  `widoczna_se` enum('tak','nie') NOT NULL,
  `widoczna_no` enum('tak','nie') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Zrzut danych tabeli `branze`
--

INSERT INTO `branze` (`id`, `nazwa_pl`, `nazwa_en`, `nazwa_se`, `nazwa_no`, `widoczna_pl`, `widoczna_en`, `widoczna_se`, `widoczna_no`) VALUES
(1, 'Budowlana', 'text_branza1', 'text_branza1', 'text_branza1', 'tak', 'nie', 'nie', 'nie'),
(2, 'Edukacja', 'text_branza2', 'text_branza2', 'text_branza2', 'tak', 'nie', 'nie', 'nie'),
(3, 'Elektroniczna', 'text_branza3', 'text_branza3', 'text_branza3', 'tak', 'nie', 'nie', 'nie'),
(4, 'Farmaceutyczna', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(5, 'Finansowa', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(6, 'Kosmetyczna', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(7, 'Meblowa', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(8, 'Media i informacje', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(9, 'Medyczna', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(10, 'Motoryzacyjna', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(11, 'Odzieżowa', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(12, 'Organizacja eventów', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(13, 'Organizacje społeczne', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(14, 'Paliwowa', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(15, 'Produkty szybkozbywalne', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(16, 'Turystyczna', '', '', '', 'tak', 'nie', 'nie', 'nie'),
(17, 'Ubezpieczeniowa', '', '', '', 'tak', 'nie', 'nie', 'nie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `branze_en`
--

CREATE TABLE IF NOT EXISTS `branze_en` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `branze_no`
--

CREATE TABLE IF NOT EXISTS `branze_no` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `branze_pl`
--

CREATE TABLE IF NOT EXISTS `branze_pl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Zrzut danych tabeli `branze_pl`
--

INSERT INTO `branze_pl` (`id`, `nazwa`, `widocznosc`) VALUES
(1, 'Budowlana', 'yes'),
(2, 'Edukacja', 'yes'),
(3, 'Elektroniczna', 'yes'),
(4, 'Farmaceutyczna', 'yes'),
(5, 'Finansowa', 'yes'),
(6, 'Kosmetyczna', 'yes'),
(7, 'Meblowa', 'yes'),
(8, 'Media i informacje', 'yes'),
(9, 'Medyczna', 'yes'),
(10, 'Motoryzacyjna', 'yes'),
(11, 'Odzieżowa', 'yes'),
(12, 'Organizacja eventów', 'yes'),
(13, 'Organizacje społeczne', 'yes'),
(14, 'Paliwowa', 'yes'),
(15, 'Produkty szybkozbywalne', 'yes'),
(16, 'Turystyczna', 'yes'),
(17, 'Ubezpieczeniowa', 'yes');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `branze_se`
--

CREATE TABLE IF NOT EXISTS `branze_se` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `cechy`
--

CREATE TABLE IF NOT EXISTS `cechy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa_pl` varchar(256) NOT NULL,
  `opis_pl` varchar(256) NOT NULL,
  `nazwa_en` varchar(256) NOT NULL,
  `opis_en` varchar(256) NOT NULL,
  `nazwa_se` varchar(256) NOT NULL,
  `opis_se` varchar(256) NOT NULL,
  `nazwa_no` varchar(256) NOT NULL,
  `opis_no` varchar(256) NOT NULL,
  `widoczna_pl` enum('tak','nie') NOT NULL,
  `widoczna_en` enum('tak','nie') NOT NULL,
  `widoczna_se` enum('tak','nie') NOT NULL,
  `widoczna_no` enum('tak','nie') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Zrzut danych tabeli `cechy`
--

INSERT INTO `cechy` (`id`, `nazwa_pl`, `opis_pl`, `nazwa_en`, `opis_en`, `nazwa_se`, `opis_se`, `nazwa_no`, `opis_no`, `widoczna_pl`, `widoczna_en`, `widoczna_se`, `widoczna_no`) VALUES
(1, 'Rozmiar', 'A4', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(2, 'Rozmiar', 'A3', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(3, 'Format', '480x300x90 mm', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(4, 'Druk', '3/0, folia matowa specjalna', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(5, 'Druk', '4/0, folia błyszcząca', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(6, 'Druk', '2/0, folia matowa', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(7, 'Druk', '4/4, folia matowa, lakier UV punktowy', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(8, 'Druk', '4/0, folia matowa', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(9, 'Druk', '4/4, folia błyszcząca wzorzysta', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(10, 'Druk', '4/4, folia matowa', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(11, 'Druk', '4/4, folia błyszcząca', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(12, 'Druk', '4/4, folia błyszcząca wzorzysta, lakier UV', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(13, 'Druk', '4/4, folia matowa, lakier UV błyszczący', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(14, 'Druk', '2/0 - srebro, czarny, folia matowa specjalna', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(15, 'Druk', '4/0, folia matowa, lakier UV', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(16, 'Druk', '4/0, laminat matowy', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(17, 'Druk', '4/0, laminat błyszczący', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(18, 'Druk', '4/4, błyszczący, kalander', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(19, 'Druk', '4/0, folia błyszcząca wzorzysta', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(20, 'Druk', '5/1, folia matowa', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(21, 'Druk', '5/5, złoto. folia błyszcząca', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(22, 'Druk', '4/4, folia błyszcząca kalandrowana', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(23, 'Druk', '4/4, laminat matowy', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak'),
(24, 'Druk', '4/4, różne laminaty, lakier wypukły', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'text_cecha', 'tak', 'tak', 'tak', 'tak');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `cechy_en`
--

CREATE TABLE IF NOT EXISTS `cechy_en` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` varchar(256) NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `cechy_no`
--

CREATE TABLE IF NOT EXISTS `cechy_no` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` varchar(256) NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `cechy_pl`
--

CREATE TABLE IF NOT EXISTS `cechy_pl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` varchar(256) NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Zrzut danych tabeli `cechy_pl`
--

INSERT INTO `cechy_pl` (`id`, `nazwa`, `opis`, `widocznosc`) VALUES
(1, 'Rozmiar', 'A4', 'yes'),
(2, 'Rozmiar', 'A3', 'yes'),
(3, 'Format', '480x300x90 mm', 'yes'),
(4, 'Druk', '3/0, folia matowa specjalna', 'yes'),
(5, 'Druk', '4/0, folia błyszcząca', 'yes'),
(6, 'Druk', '2/0, folia matowa', 'yes'),
(7, 'Druk', '4/4, folia matowa, lakier UV punktowy', 'yes'),
(8, 'Druk', '4/0, folia matowa', 'yes'),
(9, 'Druk', '4/4, folia błyszcząca wzorzysta', 'yes'),
(10, 'Druk', '4/4, folia matowa', 'yes'),
(11, 'Druk', '4/4, folia błyszcząca', 'yes'),
(12, 'Druk', '4/4, folia błyszcząca wzorzysta, lakier UV', 'yes'),
(13, 'Druk', '4/4, folia matowa, lakier UV błyszczący', 'yes'),
(14, 'Druk', '2/0 - srebro, czarny, folia matowa specjalna', 'yes'),
(15, 'Druk', '4/0, folia matowa, lakier UV', 'yes'),
(16, 'Druk', '4/0, laminat matowy', 'yes'),
(17, 'Druk', '4/0, laminat błyszczący', 'yes'),
(18, 'Druk', '4/4, błyszczący, kalander', 'yes'),
(19, 'Druk', '4/0, folia błyszcząca wzorzysta', 'yes'),
(20, 'Druk', '5/1, folia matowa', 'yes'),
(21, 'Druk', '5/5, złoto. folia błyszcząca', 'yes'),
(22, 'Druk', '4/4, folia błyszcząca kalandrowana', 'yes'),
(23, 'Druk', '4/4, laminat matowy', 'yes'),
(24, 'Druk', '4/4, różne laminaty, lakier wypukły', 'yes');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `cechy_se`
--

CREATE TABLE IF NOT EXISTS `cechy_se` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` varchar(256) NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `kategorie`
--

CREATE TABLE IF NOT EXISTS `kategorie` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa_pl` varchar(256) NOT NULL,
  `opis_pl` text NOT NULL,
  `nazwa_en` varchar(256) NOT NULL,
  `opis_en` text NOT NULL,
  `nazwa_se` varchar(256) NOT NULL,
  `opis_se` text NOT NULL,
  `nazwa_no` varchar(256) NOT NULL,
  `opis_no` text NOT NULL,
  `widoczna_pl` enum('tak','nie') NOT NULL,
  `widoczna_en` enum('tak','nie') NOT NULL,
  `widoczna_se` enum('tak','nie') NOT NULL,
  `widoczna_no` enum('tak','nie') NOT NULL,
  `zdjecia` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`id`, `nazwa_pl`, `opis_pl`, `nazwa_en`, `opis_en`, `nazwa_se`, `opis_se`, `nazwa_no`, `opis_no`, `widoczna_pl`, `widoczna_en`, `widoczna_se`, `widoczna_no`, `zdjecia`) VALUES
(1, 'Segregatory', 'Zapomnij o tym, że wszystkie segregatory są do siebie podobne. Zmienimy zwykły segregator w paletę próbek, katalog produktów, zbiór publikacji lub produktów zawsze kojarzący się z Twoją firmą.\r\n\r\nWyposażony w kolorowe przekładki segregator może stanowić funkcjonalną i estetyczną oprawę dla materiałów szkoleniowych. Wykorzystaj segregator i zamień go w reklamę swojej firmy! ', 'Custom binders', 'Forget the idea that all binders are standard. We shall change an ordinary ring binder into a sample folder, product catalogue, collection of documents or a product which will always bring your company to mind.\r\n\r\nCustom-made binder is a great way to present a wide range of products. Equipped with coloured binder dividers it can be a functional and aesthetic setting for training materials. One can find countless applications for an ordinary binder.\r\n\r\nUse a ring binder as a promotional tool for your company! ', 'Reklam sorteringsmappar', 'Glöm att alla mappar liknar varandra. Vi förändrar en vanlig mapp till en palett av prover, produktkatalog, publikationssamling eller en produkt som ger association till ditt företag.\r\n\r\nReklammappen är ett perfekt sätt att presentera ett brett produktutbud. En reklammapp med färgseparatorer kan även vara en bra form för funktionellt och vackert kursmaterial. Det finns tusentals användningsområden för en mapp.\r\n\r\nTa en mapp och förvandla den till reklam för ditt företag. ', 'Reklamepermer', 'Glem at alle reklamepermer er like. Vi skal gjøre en vanlig reklameperm til en prøvepalett, produktkatalog, en samling av publikasjoner eller et produkt som alltid minner om din bedrift.\r\n\r\nReklamepermer er en perfekt måte å presentere et bredt utvalg av produkter på. Med fargerike skillesider kan en perm fungere som en funksjonell og estetisk binding for opplæringsmateriell. Reklamepermer har utallige bruksområder.\r\n\r\nBruk reklamepermer som ditt eget reklamemedium!', 'tak', 'tak', 'tak', 'tak', 'segregator-achilles,segregator-NTA,segregator-z-przekladkami2,segregator-z-etui,segregator_p&g,segregator-assessio,segregator-ving,segregator-z-przekladkami'),
(2, 'Teczki', 'Jak dostarczyć klientowi ofertę? Zapakować ją w elegancką teczkę ofertową z logo i danymi kontaktowymi. W co zapakować ulotki i materiały promocyjne dotyczące produktu? W wygodną teczkę zamykaną na gumkę. Lista zastosowań dla popularnej "teczki" jest niezliczona.\r\n\r\nTeczka to podstawowe narzędzie promocyjne i reklamowe. To praktyczne i funkcjonalne opakowanie dla rozmaitych materiałów drukowanych. To produkt, który od momentu, kiedy trafia w ręce odbiorcy zaczyna żyć własnym życiem. ', 'Folders', 'How to provide the client with an offer? Pack it in an elegant folder with your logo and contact details printed on it. How to send leaflets and promotional materials? Choose a convenient folder with a rubber band. The list of applications for a standard folder is endless.\r\n\r\nFolders are great tools in promotion and advertising. This is a practical and functional packaging for a variety of printed materials. Moreover, folder is a product which starts to live its own life once it gets into the hands of the recipient, carrying the information of your company or brand. ', 'Pärmar', 'Hur levererar du offerter till dina kunder? Vi kan förpacka offerten i en elegant pärm med företagets logotyp och kontaktuppgifter. Hur packar du broschyrer och reklammaterial som du vill sälja? Du kan placera dessa material i en pärm med gummiband. Lista över användningsområden för en pärm är mycket lång.\r\n\r\nEn pärm är ett huvudverktyg för marknadsföring och reklam. Det är en praktisk och funktionell förpackning för tryckmaterial. Det är en produkt som efter att den har kommit till din kund, lever sitt eget liv. ', 'Mapper', 'Hvordan levere tilbudet til kunden? Pakk det inn i en elegant mappe med din logo og kontaktopplysninger. Hvordan pakke brosjyrer og reklamemateriell? I en praktisk mappe med gummistrikk. Mapper har utallige anvendelser.\r\n\r\nMapper er et vanlig verktøy som brukes i kampanjer og reklame. En praktisk og funksjonell emballasje for ulike trykksaker. Dette produktet, etter at det kommer til mottakeren, begynner å leve sitt eget liv. ', 'tak', 'tak', 'tak', 'tak', 'teczki1,teczki2,teczki3,teczki4,teczki5,teczki6,teczki7'),
(3, 'Clipboardy', 'Podkładka z klipsem, clipboard ? nieoceniona pomoc podczas szkoleń, spotkań i wykładów. Wyposażone w mechanizm do podtrzymywania papieru i miejsce na długopis mogą mieć rozmaity rozmiar.\r\n\r\nClipboardy to popularny materiał reklamowy. Wykorzystywany właściwie w każdej branży i praktycznie niezniszczalny. Nasze clipboardy przez lata będą niosły ze sobą w świat promocję twojej firmy! ', 'Clipboards', 'Clipboards are an invaluable aid during trainings, meetings and lectures. Equipped with a mechanism to support paper and place the pen. They may come in different sizes.\r\n\r\nClipboards are popular advertising tools. Clipboards produced by Achilles Polska are virtually indestructible. Our clipboards shall promote your company for many, many years.', 'Clipboard', 'Skrivunderlag med clips, clipboard – ett ovärderligt stöd under en kurs, ett möte och en föreläsning. Clipboard har en speciell mekanism som håller papper på plats med ett utrymme för penna. Clipboard kan vara i olika storlekar.\r\n\r\nClipboard är ett populärt reklammaterial. Den används i varje bransch och det håller hur länge som helst. Våra clipboard kommer att bära med sig ditt företags reklam genom åren. ', 'Skriveplater', 'Skriveplate med klype, ordrebrett – et utmerket hjelpemiddel for opplæring, møter og forelesninger. Med en klem-mekanisme og plass til pennen kan skriveplater ha ulike størrelser.\r\n\r\nSkriveplater er et populært reklamemedium. Brukes i nesten alle bransjer, og er nærmest uslitelig. Våre skriveplater skal fortelle om din bedrift i årevis!', 'tak', 'tak', 'tak', 'tak', 'clipboard0,clipboardy1,clipboardy2,clipboardy3'),
(4, 'Pudełka i etui', 'Chcesz trwale i elegancko zapakować swój produkt? Zaprojektujemy pudełko lub etui jakiego potrzebujesz. Dowolność kształtów, wielkości i kolorów, staranne wykończenie, estetyczne wzmocnienia rogów - nasze pudełka i etui stanowią doskonałą ochronę książek, skoroszytów, pomagają archiwizować i porządkować dokumenty. Mogą też być eleganckim opakowaniem produktu lub upominku. ', 'Boxes and cases', 'Do you need a durable and elegant packaging for your product? We shall design a box or a case tailored to your needs. You are free to chose shape, size and colour - we will provide a neat finish of the corners. Our boxes and cases may be a perfect protection for books or ring binders, they may help to sort out documents. They may also become and elegant wrapping for a product or a gift. ', 'Förpackningar och fodral', 'Vill du packa din produkt på ett fint och hållbart sätt? Vi tar fram design på en förpackning eller fodral som du behöver. De kan variera i former, storlekar och färger, allt med noggranna detaljer, hörnförstärkning – våra boxar och fodral skyddar effektivt både böcker och pärmar samt hjälper med arkivering och att hålla ordning bland dokument. De kan också vara en elegant förpackning för en produkt eller present. ', 'Esker og etui', 'Vil du pakke ditt produkt på en varig og elegant måte? Vi kan prosjektere en eske eller etui for deg. Alle mulige former, størrelser og farger, omhyggelig finish, estetisk forsterkede hjørner – våre esker og etui gir utmerket beskyttelse for bøker og hefter, og hjelper med arkivering og håndtering av dokumenter. De kan også brukes som elegant innpakning av produkter eller gaver. ', 'tak', 'tak', 'tak', 'tak', 'pudelka-etui1,pudelka-etui2,pudelka-etui3,pudelka-etui4,pudelka-etui5,pudelka-etui6'),
(5, 'Prezentery', 'Prezenter to wygodne i funkcjonalne narzędzie, które pomoże ci opowiedzieć o firmie, produkcie czy usłudze. Możesz go zabrać na spotkanie z klientem - w razie potrzeby prezenter zamieni się w tablicę suchościeralną.\r\n\r\nPrezentery mogą mieć rozmaitą formę, wielkość i kształt. Możliwości Achilles Polska w tym zakresie są nieograniczone. Dodatkowe akcesoria takie jak tablica, marker i gąbka zmienią zwykły prezenter w niezwykłe narzędzie promocyjne.\r\n\r\nPrezenter to efektywna pomoc w prezentacji firmy, produktu, usługi. ', 'Easel binders', 'Easel binder is a convenient and functional tool that may help you present your company, product or service. You can take it to your client - if necessary, your easel binder will turn into a whiteboard.\r\n\r\nEasel binders may come in various shapes and sizes. With Achilles Polska your possibilities are unlimited. Additional accessories such as whiteboard, marker and a sponge change the regular easel binder in an unusual promotional tool.\r\n\r\nEasel binder is an effective aid in presenting of the company, product, or services. ', 'Presentationsbord', 'Presentationsbord är ett bekvämt och funktionellt verktyg som kan vara ett stöd när du vill berätta om ditt företag, produkt eller tjänst. Du kan enkelt ta den med dig till ditt kundmöte och det kan användas även som ett vanligt skrivbord om så behövs.\r\n\r\nPresentationsbord kan vara i olika former, storlekar och utformningar. Det finns inga begränsningar för oss i det avseende. Extra tillbehör som själva skrivbord, penna eller svamp kan förvandla ett vanligt presentationsbord i ett unikt marknadsföringsverktyg.\r\n\r\nPresentationsbord – ett effektivt stöd för presentation av ett företag, produkt, tjänst. ', 'Presentasjonsmapper', 'En presentasjonsmappe er et praktisk og funksjonelt verktøy som hjelper deg å fortelle om din bedrift, produkt eller tjeneste. Du kan ta den med deg – den kan brukes som en whiteboardtavle hvis det trengs.\r\n\r\nPresentasjonsmapper kan ha ulike former og størrelser. Mulighetene er uendelige. Med tilbehør som tavle, tusj og pussekloss blir en vanlig presentasjonsmappe til et fantastisk salgsfremmende verktøy.\r\n\r\nPresentasjonsmappe – et effektivt hjelpemiddel ved presentering av bedrift, produkt og tjeneste. ', 'tak', 'tak', 'tak', 'tak', 'prezenter1,prezenter2,prezenter3,prezenter4'),
(6, 'Wzorniki i próbki', 'Nie wszystkie produkty można zaprezentować na zdjęciach. Niejednokrotnie ważniejsze od zdjęcia jest odpowiednie wyeksponowanie materiałów, kolorów, faktur. Tworzymy unikalne i funkcjonalne opakowania dla próbek i wzorów Twoich produktów. Dzięki nim produkty nie tylko można zobaczyć, ale i dotknąć, oceniając walory niedostrzegalne na fotografiach.\r\n\r\nWzorniki i próbniki to niezbędne narzędzie pracy handlowców i pracowników sieci dystrybucji.\r\n\r\nPrzynieś do nas materiały, które chcesz zaprezentować, a my stworzymy wzornik lub próbnik jakiego potrzebujesz. ', 'Sample folders', 'Not all the products can be presented in pictures. It is often vital to expose material, colour or texture. We create unique and functional folders for your product samples. Thanks to sample folders products can not only be seen but also felt.\r\n\r\nSample folders are an important working-tool for tradesmen and merchants. Show us the samples you need to present and we will make a folder tailored to your needs. ', 'Provpärmar', 'Inte alla produkter kan presenteras på bilder. Många gånger viktigare än själva bilden är en bra exponering av material, färger, textur. Vi skapar unika och funktionella förpackningar för dina produktprover. Tack vare detta kan din kund inte bara se men även röra och bedöma fördelar av din produkt som inte syns på bilden.\r\n\r\nProvmappar är viktiga verktyg för säljare och distributionsnätverk.\r\n\r\nTa med dig material som du vill visa och vi tar fram en provmapp som motsvarar dina behov. ', 'Mønsterbøker og fargeprøver', 'Ikke alle produkter kan presenteres på bilder. Ofte er det viktigere å eksponere materialer, farger og teksturer. Vi lager unike og funksjonelle emballasjer for prøver og mønstre av dine produkter. Kunden ikke bare ser produktet, men kan også ta på det og vurdere de kvalitetene som ikke ses på vanlige bilder.\r\n\r\nMønsterbøker er nødvendige verktøy for selgere og alle i distribusjonsnettet.\r\n\r\nBring til oss det du vil presentere, og vi skaper en mønsterbok du trenger. ', 'tak', 'tak', 'tak', 'tak', 'wzornik-tynki2,wzornik-tkanin,wzornik-drewno,wzornik_tynki1,soczewki,wzornik-tynki3,wzornik_wachlarz,wzornik-pudelko'),
(7, 'Receptariusze', 'Jedna z naszych propozycji dla branży medycznej - receptariusze. To funkcjonalna teczka, z szeroką paletą możliwych zamknięć i dodatków, przeznaczona do przechowywania recept. Niezbędne narzędzie każdego lekarza. Doskonałe narzędzie promocji dla firm farmaceutycznych, a przy okazji praktyczny upominek.', '', '', 'Receptblock', 'Ett av våra förslag till medicinbranschen – receptblock. En funktionell mapp med olika möjligheter för förslutning och extra tillbehör, som används för att förvara recept. Ett måste för varje läkare. Ett mycket effektivt verktyg för läkemedelbolag, och samtidigt en mycket praktisk present. ', 'Reseptmapper', 'Ett av våre forslag til medisinsk bransje - reseptmapper. En praktisk mappe, med ulike låsemuligheter og tilbehør, egnet for oppbevaring av resepter. Et verktøy som alle leger trenger. Et perfekt salgsfremmende verktøy for legemiddel leverandører, og samtidig en praktisk gave. ', 'tak', 'nie', 'tak', 'tak', 'receptariusz1,receptariusz2,receptariusz3,receptariusz4'),
(8, 'Opakowania na alkohole', 'Ekskluzywne trunki wymagają eleganckiego opakowania. Nasze propozycje opakowań na alkohole to doskonała alternatywa dla pudełek z metalu czy drewna.\r\n\r\nNasze opakowania mogą mieć dostosowany do potrzeb klienta rozmiar i dowolny nadruk.\r\n\r\nDostępne są trzy podstawowe wzory opakowań - każde o innych funkcjonalnościach i możliwościach. Trunek opakowany w taki estetyczny sposób to niezwykle elegancki prezent. Wartościowa zawartość i efektowna oprawa nadają mu podwójnej mocy.\r\n\r\nNa zdjęciach zaprezentowano przykłady wykorzystania opakowań jako pudełko na wino.', 'Boxes for wines and spirits', 'Exclusive drinks require an elegant packaging.\r\n\r\nOur boxes for wines and spirits are a great alternative for packaging made of metal or wood. Both the size and design of the box may be customized, which gives great opportunities.\r\n\r\nThere are three basic kinds of boxes for wines and spirits - each with different advantages. A bottle of wine or liquor packaged in such an aesthetic way is a truly elegant gift. Valuable content and spectacular packaging guarantees a hundred percent success.', 'Förpackningar för vin och sprit', 'Exklusiva drycker kräver en elegant förpackning. Våra lådor för vin och sprit är ett fantastiskt alternativ för boxar i metall eller trä. Både storlek och tryck kan anpassas vilket ger enorma möjligheter. Det finns tre grundutföranden av lådor för vin och sprit – alla med olika fördelar. En flaska vin eller sprit förpackad i en fin låda är en riktigt elegant gåva. Värdefullt innehåll och spektakulär förpackning skickar en kraftfull signal.', 'Innpakning for drikkevarer', 'Eksklusive drikkevarer krever en elegant innpakning. Våre esker er et tiltalende alternativ til emballasjer laget av metall eller tre. Du kan velge både størrelse og påtrykk på esker. Vi tilbyr bokser i tre ulike standardstørrelser; hver størrelse med sine egne fordeler og funksjoner. En flaske god vin eller sprit i en slik fin emballasje er en meget stilig gave. Verdifullt innhold og en praktfull innpakning gir en dobbel glede. ', 'tak', 'tak', 'tak', 'tak', 'pudelko1,pudelko2,pudelko3,pudelko4,pudelko5'),
(9, 'Wizytowniki', 'Produkty promocyjne poza reklamowaniem Państwa firmy mogą spełniać także rolę użytkową. Dzięki temu, kiedy trafiają w ręce odbiorcy zaczynają żyć własnym życiem i stają się doskonałym nośnikiem identyfikowanym z firmą, marką czy usługą.\r\n\r\nWizytownik to doskonały wybór jeśli chcemy przygotować efektowny i praktyczny upominek. ', 'Business card folders', 'Apart from sending out your brand message, promotional products may also be usable. Such useful items start to live their own life and carry your company''s name wherever they go.\r\n\r\nCustom-made business card holders are a perfect choice if you want to prepare an attractive and usable gift. ', 'Visitkortshållare', 'Marknadsföringsprodukter, förutom dess roll som reklam, kan även vara mycket användbara. När de hamnar hos kunden kan de leva sitt eget liv och blir en fantastisk reklambärare som identifieras med ett visst företag, märke eller tjänst.\r\n\r\nEn visitkortshållare är ett mycket bra val om du vill ge en praktisk och fin present.', 'Visittkortmapper', 'Markedsføringsprodukter kan også være praktiske. Hos mottakeren lever de sitt eget liv og er et utmerket medium som identifiseres med bedriften, varemerke eller tjeneste.\r\n\r\nEn visittkortmappe er perfekt som en attraktiv og praktisk gave. ', 'tak', 'tak', 'tak', 'tak', 'wizytowniki1,wizytowniki2,wizytowniki3'),
(10, 'Produkty z polipropylenu', 'Produkty prezentacyjne z polipropylenu to alternatywa dla wyrobów z kartonu. Z polipropylenu zrobić można wszystko: segregatory, teczki, etui. Polipropylen daje ogromne możliwości kreacji produktów, zgodnie z oczekiwaniami klientów. Co istotne, produkty te są niezwykle wytrzymałe i można je dowolnie zadrukowywać.\r\n\r\nDecydując się na produkt z polipropylenu nie musisz ograniczać się do mlecznobiałej, przezroczystej teczki - wybierz dowolny z szerokiej palety kolorów, zdecyduj jaka faktura najbardziej ci odpowiada, a my stworzymy produkt, który cię zachwyci!', 'Polypropylene products', 'Presentation products made of polypropylene are an alternative to cardboard binders, folders or cases. Polypropylene offers great flexibility and allows us to create products meeting our customers’ needs. What is most important, such products are extremely durable and can be freely printed on.\r\n\r\nWith polypropylene you are not limited to milky, translucent folders - choose any of a wide range of colours and textures. Decide which suits you best, and we will create a product you will be delighted with!', '', '', '', '', 'tak', 'tak', 'nie', 'nie', 'produkty_PP1,produkty_PP2,produkty_PP2a,produkty_PP3,produkty_PP4\r\n'),
(11, 'Stojak na ulotki', 'Ulotki to sprawdzona metoda bezpośredniego dotarcia do klienta. Główna zaleta ulotek polega na tym, że możemy zostawić je w miejscach, do których trafiają nasi potencjalni klienci. Co jednak zrobić, żeby ulotki prezentowały się elegancko? Warto skorzystać ze stojaka na ulotki! Ten prosty w montażu zgrabny stojak zagwarantuje nam, że ulotki wyglądać będą estetycznie i klienci sięgną po nie z zainteresowaniem.\r\n\r\nStojaki na ulotki dostępne są w różnych rozmiarach i mogą być dowolnie zadrukowywane. Jeśli poszukują Państwo niestandardowego rozwiązania, stworzymy produkt, który spełni Państwa oczekiwania.', 'Leaflet dispensers', 'Leaflets can be a very effective and economical way of advertising to a large target group. One of the advantages is that leaflets may be left in places visited by potential customers. If you wonder what to do to present leaflets in an elegant way, use a leaflet dispenser! This simple-to-install stand guarantees that leaflets will look aesthetically, and customers shall reach for them with interest.\r\n\r\nLeaflet dispensers are available in various sizes and can be freely printed on. If you are looking for a non-standard solution, we will create a product that will meet your expectations.', '', '', '', '', 'tak', 'tak', 'nie', 'nie', 'ulotkownik1,ulotkownik2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `kategorie_en`
--

CREATE TABLE IF NOT EXISTS `kategorie_en` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  `zdjecia` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Zrzut danych tabeli `kategorie_en`
--

INSERT INTO `kategorie_en` (`id`, `nazwa`, `opis`, `widocznosc`, `zdjecia`) VALUES
(1, 'Custom binders', 'Forget the idea that all binders are standard. We shall change an ordinary ring binder into a sample folder, product catalogue, collection of documents or a product which will always bring your company to mind.\r\n\r\nCustom-made binder is a great way to present a wide range of products. Equipped with coloured binder dividers it can be a functional and aesthetic setting for training materials. One can find countless applications for an ordinary binder.\r\n\r\nUse a ring binder as a promotional tool for your company! ', 'yes', ',segregator-achilles,segregator-NTA,segregator-z-przekladkami2,segregator-z-etui,segregator_p&g,segregator-assessio,segregator-ving,segregator-z-przekladkami,'),
(2, 'Folders', 'How to provide the client with an offer? Pack it in an elegant folder with your logo and contact details printed on it. How to send leaflets and promotional materials? Choose a convenient folder with a rubber band. The list of applications for a standard folder is endless.\r\n\r\nFolders are great tools in promotion and advertising. This is a practical and functional packaging for a variety of printed materials. Moreover, folder is a product which starts to live its own life once it gets into the hands of the recipient, carrying the information of your company or brand. ', 'yes', ',teczki1,teczki2,teczki3,teczki4,teczki5,teczki6,teczki7,'),
(3, 'Clipboards', 'Clipboards are an invaluable aid during trainings, meetings and lectures. Equipped with a mechanism to support paper and place the pen. They may come in different sizes.\r\n\r\nClipboards are popular advertising tools. Clipboards produced by Achilles Polska are virtually indestructible. Our clipboards shall promote your company for many, many years.', 'yes', ',clipboard0,clipboardy1,clipboardy2,clipboardy3,'),
(4, 'Boxes and cases', 'Do you need a durable and elegant packaging for your product? We shall design a box or a case tailored to your needs. You are free to chose shape, size and colour - we will provide a neat finish of the corners. Our boxes and cases may be a perfect protection for books or ring binders, they may help to sort out documents. They may also become and elegant wrapping for a product or a gift. ', 'yes', ',pudelka-etui1,pudelka-etui2,pudelka-etui3,pudelka-etui4,pudelka-etui5,pudelka-etui6,'),
(5, 'Easel binders', 'Easel binder is a convenient and functional tool that may help you present your company, product or service. You can take it to your client - if necessary, your easel binder will turn into a whiteboard.\r\n\r\nEasel binders may come in various shapes and sizes. With Achilles Polska your possibilities are unlimited. Additional accessories such as whiteboard, marker and a sponge change the regular easel binder in an unusual promotional tool.\r\n\r\nEasel binder is an effective aid in presenting of the company, product, or services. ', 'yes', ',prezenter1,prezenter2,prezenter3,prezenter4,'),
(6, 'Sample folders', 'Not all the products can be presented in pictures. It is often vital to expose material, colour or texture. We create unique and functional folders for your product samples. Thanks to sample folders products can not only be seen but also felt.\r\n\r\nSample folders are an important working-tool for tradesmen and merchants. Show us the samples you need to present and we will make a folder tailored to your needs. ', 'yes', ',wzornik-tynki2,wzornik-tkanin,wzornik-drewno,wzornik_tynki1,soczewki,wzornik-tynki3,wzornik_wachlarz,wzornik-pudelko,'),
(7, '', '', 'no', ',receptariusz1,receptariusz2,receptariusz3,receptariusz4,'),
(8, 'Boxes for wines and spirits', 'Exclusive drinks require an elegant packaging.\r\n\r\nOur boxes for wines and spirits are a great alternative for packaging made of metal or wood. Both the size and design of the box may be customized, which gives great opportunities.\r\n\r\nThere are three basic kinds of boxes for wines and spirits - each with different advantages. A bottle of wine or liquor packaged in such an aesthetic way is a truly elegant gift. Valuable content and spectacular packaging guarantees a hundred percent success.', 'yes', ',pudelko1,pudelko2,pudelko3,pudelko4,pudelko5,'),
(9, 'Business card folders', 'Apart from sending out your brand message, promotional products may also be usable. Such useful items start to live their own life and carry your company''s name wherever they go.\r\n\r\nCustom-made business card holders are a perfect choice if you want to prepare an attractive and usable gift. ', 'yes', ',wizytowniki1,wizytowniki2,wizytowniki3,'),
(10, 'Polypropylene products', 'Presentation products made of polypropylene are an alternative to cardboard binders, folders or cases. Polypropylene offers great flexibility and allows us to create products meeting our customers’ needs. What is most important, such products are extremely durable and can be freely printed on.\r\n\r\nWith polypropylene you are not limited to milky, translucent folders - choose any of a wide range of colours and textures. Decide which suits you best, and we will create a product you will be delighted with!', 'yes', ',produkty_PP1,produkty_PP2,produkty_PP2a,produkty_PP3,produkty_PP4\r\n,'),
(11, 'Leaflet dispensers', 'Leaflets can be a very effective and economical way of advertising to a large target group. One of the advantages is that leaflets may be left in places visited by potential customers. If you wonder what to do to present leaflets in an elegant way, use a leaflet dispenser! This simple-to-install stand guarantees that leaflets will look aesthetically, and customers shall reach for them with interest.\r\n\r\nLeaflet dispensers are available in various sizes and can be freely printed on. If you are looking for a non-standard solution, we will create a product that will meet your expectations.', 'yes', ',ulotkownik1,ulotkownik2,'),
(12, 'Paper bags', 'The simplest solutions are often the best, so it is always handy to have same spare paper bags with company’s logo. They may become a packaging for namely everything: both a product catalog and an elegant gift for a customer. We produce bags in various sizes. Additionally, we offer a wide variety of high quality finishes, so that a paper bag is both very stylish and very durable.', 'yes', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `kategorie_no`
--

CREATE TABLE IF NOT EXISTS `kategorie_no` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  `zdjecia` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Zrzut danych tabeli `kategorie_no`
--

INSERT INTO `kategorie_no` (`id`, `nazwa`, `opis`, `widocznosc`, `zdjecia`) VALUES
(1, 'Reklamepermer', 'Glem at alle reklamepermer er like. Vi skal gjøre en vanlig reklameperm til en prøvepalett, produktkatalog, en samling av publikasjoner eller et produkt som alltid minner om din bedrift.\r\n\r\nReklamepermer er en perfekt måte å presentere et bredt utvalg av produkter på. Med fargerike skillesider kan en perm fungere som en funksjonell og estetisk binding for opplæringsmateriell. Reklamepermer har utallige bruksområder.\r\n\r\nBruk reklamepermer som ditt eget reklamemedium!', 'yes', ',segregator-achilles,segregator-NTA,segregator-z-przekladkami2,segregator-z-etui,segregator_p&g,segregator-assessio,segregator-ving,segregator-z-przekladkami,'),
(2, 'Mapper', 'Hvordan levere tilbudet til kunden? Pakk det inn i en elegant mappe med din logo og kontaktopplysninger. Hvordan pakke brosjyrer og reklamemateriell? I en praktisk mappe med gummistrikk. Mapper har utallige anvendelser.\r\n\r\nMapper er et vanlig verktøy som brukes i kampanjer og reklame. En praktisk og funksjonell emballasje for ulike trykksaker. Dette produktet, etter at det kommer til mottakeren, begynner å leve sitt eget liv.', 'yes', ',teczki1,teczki2,teczki3,teczki4,teczki5,teczki6,teczki7,'),
(3, 'Skriveplater', 'Skriveplate med klype, ordrebrett – et utmerket hjelpemiddel for opplæring, møter og forelesninger. Med en klem-mekanisme og plass til pennen kan skriveplater ha ulike størrelser.\r\n\r\nSkriveplater er et populært reklamemedium. Brukes i nesten alle bransjer, og er nærmest uslitelig. Våre skriveplater skal fortelle om din bedrift i årevis!', 'yes', ',clipboard0,clipboardy1,clipboardy2,clipboardy3,'),
(4, 'Esker og etui', 'Vil du pakke ditt produkt på en varig og elegant måte? Vi kan prosjektere en eske eller etui for deg. Alle mulige former, størrelser og farger, omhyggelig finish, estetisk forsterkede hjørner – våre esker og etui gir utmerket beskyttelse for bøker og hefter, og hjelper med arkivering og håndtering av dokumenter. De kan også brukes som elegant innpakning av produkter eller gaver. ', 'yes', ',pudelka-etui1,pudelka-etui2,pudelka-etui3,pudelka-etui4,pudelka-etui5,pudelka-etui6,'),
(5, 'Presentasjonsmapper', 'En presentasjonsmappe er et praktisk og funksjonelt verktøy som hjelper deg å fortelle om din bedrift, produkt eller tjeneste. Du kan ta den med deg – den kan brukes som en whiteboardtavle hvis det trengs.\r\n\r\nPresentasjonsmapper kan ha ulike former og størrelser. Mulighetene er uendelige. Med tilbehør som tavle, tusj og pussekloss blir en vanlig presentasjonsmappe til et fantastisk salgsfremmende verktøy.\r\n\r\nPresentasjonsmappe – et effektivt hjelpemiddel ved presentering av bedrift, produkt og tjeneste. ', 'yes', ',prezenter1,prezenter2,prezenter3,prezenter4,'),
(6, 'Mønsterbøker og fargeprøver', 'Ikke alle produkter kan presenteres på bilder. Ofte er det viktigere å eksponere materialer, farger og teksturer. Vi lager unike og funksjonelle emballasjer for prøver og mønstre av dine produkter. Kunden ikke bare ser produktet, men kan også ta på det og vurdere de kvalitetene som ikke ses på vanlige bilder.\r\n\r\nMønsterbøker er nødvendige verktøy for selgere og alle i distribusjonsnettet.\r\n\r\nBring til oss det du vil presentere, og vi skaper en mønsterbok du trenger. ', 'yes', ',wzornik-tynki2,wzornik-tkanin,wzornik-drewno,wzornik_tynki1,soczewki,wzornik-tynki3,wzornik_wachlarz,wzornik-pudelko,'),
(7, 'Reseptmapper', 'Ett av våre forslag til medisinsk bransje - reseptmapper. En praktisk mappe, med ulike låsemuligheter og tilbehør, egnet for oppbevaring av resepter. Et verktøy som alle leger trenger. Et perfekt salgsfremmende verktøy for legemiddel leverandører, og samtidig en praktisk gave. ', 'yes', ',receptariusz1,receptariusz2,receptariusz3,receptariusz4,'),
(8, 'Innpakning for drikkevarer', 'Eksklusive drikkevarer krever en elegant innpakning. Våre esker er et tiltalende alternativ til emballasjer laget av metall eller tre. Du kan velge både størrelse og påtrykk på esker. Vi tilbyr bokser i tre ulike standardstørrelser; hver størrelse med sine egne fordeler og funksjoner. En flaske god vin eller sprit i en slik fin emballasje er en meget stilig gave. Verdifullt innhold og en praktfull innpakning gir en dobbel glede. ', 'yes', ',pudelko1,pudelko2,pudelko3,pudelko4,pudelko5,'),
(9, 'Visittkortmapper', 'Markedsføringsprodukter kan også være praktiske. Hos mottakeren lever de sitt eget liv og er et utmerket medium som identifiseres med bedriften, varemerke eller tjeneste.\r\n\r\nEn visittkortmappe er perfekt som en attraktiv og praktisk gave. ', 'yes', ',wizytowniki1,wizytowniki2,wizytowniki3,'),
(10, 'Polypropylen', 'Polypropylen', 'no', ',produkty_PP1,produkty_PP2,produkty_PP2a,produkty_PP3,produkty_PP4\r\n,'),
(11, 'Står for flyers', 'Står for flyers', 'no', ',ulotkownik1,ulotkownik2,');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `kategorie_pl`
--

CREATE TABLE IF NOT EXISTS `kategorie_pl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  `zdjecia` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Zrzut danych tabeli `kategorie_pl`
--

INSERT INTO `kategorie_pl` (`id`, `nazwa`, `opis`, `widocznosc`, `zdjecia`) VALUES
(1, 'Segregatory', 'Zapomnij o tym, że wszystkie segregatory są do siebie podobne. Zmienimy zwykły segregator w paletę próbek, katalog produktów, zbiór publikacji lub produktów zawsze kojarzący się z Twoją firmą.\r\n\r\nWyposażony w kolorowe przekładki segregator może stanowić funkcjonalną i estetyczną oprawę dla materiałów szkoleniowych. Wykorzystaj segregator i zamień go w reklamę swojej firmy!', 'yes', ',segregator-achilles,segregator-NTA,segregator_p&g,segregator-assessio,segregator-ving,segregator-z-przekladkami,segregator-z-przekladkami2,segregator-z-etui,'),
(2, 'Teczki', 'Jak dostarczyć klientowi ofertę? Zapakować ją w elegancką teczkę ofertową z logo i danymi kontaktowymi. W co zapakować ulotki i materiały promocyjne dotyczące produktu? W wygodną teczkę zamykaną na gumkę. Lista zastosowań dla popularnej "teczki" jest niezliczona.\r\n\r\nTeczka to podstawowe narzędzie promocyjne i reklamowe. To praktyczne i funkcjonalne opakowanie dla rozmaitych materiałów drukowanych. To produkt, który od momentu, kiedy trafia w ręce odbiorcy zaczyna żyć własnym życiem. ', 'yes', ',teczki2,teczki3,teczki4,teczki5,teczki6,teczki7,teczki1,'),
(3, 'Clipboardy', 'Podkładka z klipsem, clipboard ? nieoceniona pomoc podczas szkoleń, spotkań i wykładów. Wyposażone w mechanizm do podtrzymywania papieru i miejsce na długopis mogą mieć rozmaity rozmiar.\r\n\r\nClipboardy to popularny materiał reklamowy. Wykorzystywany właściwie w każdej branży i praktycznie niezniszczalny. Nasze clipboardy przez lata będą niosły ze sobą w świat promocję twojej firmy! ', 'yes', ',clipboard0,clipboardy1,clipboardy2,clipboardy3,'),
(4, 'Pudełka i etui', 'Chcesz trwale i elegancko zapakować swój produkt? Zaprojektujemy pudełko lub etui jakiego potrzebujesz. Dowolność kształtów, wielkości i kolorów, staranne wykończenie, estetyczne wzmocnienia rogów - nasze pudełka i etui stanowią doskonałą ochronę książek, skoroszytów, pomagają archiwizować i porządkować dokumenty. Mogą też być eleganckim opakowaniem produktu lub upominku. ', 'yes', ',pudelka-etui1,pudelka-etui2,pudelka-etui3,pudelka-etui4,pudelka-etui5,pudelka-etui6,'),
(5, 'Prezentery', 'Prezenter to wygodne i funkcjonalne narzędzie, które pomoże ci opowiedzieć o firmie, produkcie czy usłudze. Możesz go zabrać na spotkanie z klientem - w razie potrzeby prezenter zamieni się w tablicę suchościeralną.\r\n\r\nPrezentery mogą mieć rozmaitą formę, wielkość i kształt. Możliwości Achilles Polska w tym zakresie są nieograniczone. Dodatkowe akcesoria takie jak tablica, marker i gąbka zmienią zwykły prezenter w niezwykłe narzędzie promocyjne.\r\n\r\nPrezenter to efektywna pomoc w prezentacji firmy, produktu, usługi. ', 'yes', ',prezenter1,prezenter2,prezenter3,prezenter4,'),
(6, 'Wzorniki i próbki', 'Nie wszystkie produkty można zaprezentować na zdjęciach. Niejednokrotnie ważniejsze od zdjęcia jest odpowiednie wyeksponowanie materiałów, kolorów, faktur. Tworzymy unikalne i funkcjonalne opakowania dla próbek i wzorów Twoich produktów. Dzięki nim produkty nie tylko można zobaczyć, ale i dotknąć, oceniając walory niedostrzegalne na fotografiach.\r\n\r\nWzorniki i próbniki to niezbędne narzędzie pracy handlowców i pracowników sieci dystrybucji.\r\n\r\nPrzynieś do nas materiały, które chcesz zaprezentować, a my stworzymy wzornik lub próbnik jakiego potrzebujesz. ', 'yes', ',wzornik-tynki2,wzornik-tkanin,wzornik-drewno,wzornik_tynki1,soczewki,wzornik-tynki3,wzornik_wachlarz,wzornik-pudelko,'),
(7, 'Receptariusze', 'Jedna z naszych propozycji dla branży medycznej - receptariusze. To funkcjonalna teczka, z szeroką paletą możliwych zamknięć i dodatków, przeznaczona do przechowywania recept. Niezbędne narzędzie każdego lekarza. Doskonałe narzędzie promocji dla firm farmaceutycznych, a przy okazji praktyczny upominek.', 'yes', ',receptariusz1,receptariusz2,receptariusz3,receptariusz4,'),
(8, 'Opakowania na alkohole', 'Ekskluzywne trunki wymagają eleganckiego opakowania. Nasze propozycje opakowań na alkohole to doskonała alternatywa dla pudełek z metalu czy drewna.\r\n\r\nNasze opakowania mogą mieć dostosowany do potrzeb klienta rozmiar i dowolny nadruk.\r\n\r\nDostępne są trzy podstawowe wzory opakowań - każde o innych funkcjonalnościach i możliwościach. Trunek opakowany w taki estetyczny sposób to niezwykle elegancki prezent. Wartościowa zawartość i efektowna oprawa nadają mu podwójnej mocy.\r\n\r\nNa zdjęciach zaprezentowano przykłady wykorzystania opakowań jako pudełko na wino.', 'yes', ',pudelko1,pudelko2,pudelko3,pudelko4,pudelko5,'),
(9, 'Wizytowniki', 'Produkty promocyjne poza reklamowaniem Państwa firmy mogą spełniać także rolę użytkową. Dzięki temu, kiedy trafiają w ręce odbiorcy zaczynają żyć własnym życiem i stają się doskonałym nośnikiem identyfikowanym z firmą, marką czy usługą.\r\n\r\nWizytownik to doskonały wybór jeśli chcemy przygotować efektowny i praktyczny upominek. ', 'yes', ',wizytowniki1,wizytowniki2,wizytowniki3,'),
(10, 'Produkty z polipropylenu', 'Produkty prezentacyjne z polipropylenu to alternatywa dla wyrobów z kartonu. Z polipropylenu zrobić można wszystko: segregatory, teczki, etui. Polipropylen daje ogromne możliwości kreacji produktów, zgodnie z oczekiwaniami klientów. Co istotne, produkty te są niezwykle wytrzymałe i można je dowolnie zadrukowywać.\r\n\r\nDecydując się na produkt z polipropylenu nie musisz ograniczać się do mlecznobiałej, przezroczystej teczki - wybierz dowolny z szerokiej palety kolorów, zdecyduj jaka faktura najbardziej ci odpowiada, a my stworzymy produkt, który cię zachwyci!', 'yes', ',produkty_PP1,produkty_PP2,produkty_PP2a,produkty_PP3,produkty_PP4\r\n,'),
(11, 'Stojak na ulotki', 'Ulotki to sprawdzona metoda bezpośredniego dotarcia do klienta. Główna zaleta ulotek polega na tym, że możemy zostawić je w miejscach, do których trafiają nasi potencjalni klienci. Co jednak zrobić, żeby ulotki prezentowały się elegancko? Warto skorzystać ze stojaka na ulotki! Ten prosty w montażu zgrabny stojak zagwarantuje nam, że ulotki wyglądać będą estetycznie i klienci sięgną po nie z zainteresowaniem.\r\n\r\nStojaki na ulotki dostępne są w różnych rozmiarach i mogą być dowolnie zadrukowywane. Jeśli poszukują Państwo niestandardowego rozwiązania, stworzymy produkt, który spełni Państwa oczekiwania.', 'yes', ',ulotkownik2,ulotkownik1,'),
(12, 'Torby reklamowe', 'Papierowe torby reklamowe to prosty i elegancki sposób na opakowanie materiałów promocyjnych czy upominków przekazywanych klientom. Estetycznie zaprojektowana, solidnie wykonana i pięknie uszlachetniona torba to świetny nośnik informacji o firmie.', 'no', ''),
(13, 'Torby reklamowe', 'Najprostsze rozwiązania często są najlepsze, dlatego zawsze warto mieć zapas firmowych toreb reklamowych, w które zapakujemy wszystko: od katalogu produktów, po elegancki upominek. Produkujemy torby w różnych rozmiarach. Dodatkowo oferujemy szeroką gamę uszlachetnień, które sprawią, że torba firmowa będzie zarówno wyjątkowo elegancka, jak i bardzo wytrzymała.', 'no', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `kategorie_se`
--

CREATE TABLE IF NOT EXISTS `kategorie_se` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `widocznosc` enum('yes','no') NOT NULL DEFAULT 'yes',
  `zdjecia` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Zrzut danych tabeli `kategorie_se`
--

INSERT INTO `kategorie_se` (`id`, `nazwa`, `opis`, `widocznosc`, `zdjecia`) VALUES
(1, 'Reklam sorteringsmappar', 'Glöm att alla mappar liknar varandra. Vi förändrar en vanlig mapp till en palett av prover, produktkatalog, publikationssamling eller en produkt som ger association till ditt företag.\r\n\r\nReklammappen är ett perfekt sätt att presentera ett brett produktutbud. En reklammapp med färgseparatorer kan även vara en bra form för funktionellt och vackert kursmaterial. Det finns tusentals användningsområden för en mapp.\r\n\r\nTa en mapp och förvandla den till reklam för ditt företag.', 'yes', ',segregator-achilles,segregator-NTA,segregator-z-przekladkami2,segregator-z-etui,segregator_p&g,segregator-assessio,segregator-ving,segregator-z-przekladkami,'),
(2, 'Pärmar', 'Hur levererar du offerter till dina kunder? Vi kan förpacka offerten i en elegant pärm med företagets logotyp och kontaktuppgifter. Hur packar du broschyrer och reklammaterial som du vill sälja? Du kan placera dessa material i en pärm med gummiband. Lista över användningsområden för en pärm är mycket lång.\r\n\r\nEn pärm är ett huvudverktyg för marknadsföring och reklam. Det är en praktisk och funktionell förpackning för tryckmaterial. Det är en produkt som efter att den har kommit till din kund, lever sitt eget liv. ', 'yes', ',teczki1,teczki2,teczki3,teczki4,teczki5,teczki6,teczki7,'),
(3, 'Clipboard', 'Skrivunderlag med clips, clipboard – ett ovärderligt stöd under en kurs, ett möte och en föreläsning. Clipboard har en speciell mekanism som håller papper på plats med ett utrymme för penna. Clipboard kan vara i olika storlekar.\r\n\r\nClipboard är ett populärt reklammaterial. Den används i varje bransch och det håller hur länge som helst. Våra clipboard kommer att bära med sig ditt företags reklam genom åren. ', 'yes', ',clipboard0,clipboardy1,clipboardy2,clipboardy3,'),
(4, 'Förpackningar och fodral', 'Vill du packa din produkt på ett fint och hållbart sätt? Vi tar fram design på en förpackning eller fodral som du behöver. De kan variera i former, storlekar och färger, allt med noggranna detaljer, hörnförstärkning – våra boxar och fodral skyddar effektivt både böcker och pärmar samt hjälper med arkivering och att hålla ordning bland dokument. De kan också vara en elegant förpackning för en produkt eller present. ', 'yes', ',pudelka-etui1,pudelka-etui2,pudelka-etui3,pudelka-etui4,pudelka-etui5,pudelka-etui6,'),
(5, 'Presentationsbord', 'Presentationsbord är ett bekvämt och funktionellt verktyg som kan vara ett stöd när du vill berätta om ditt företag, produkt eller tjänst. Du kan enkelt ta den med dig till ditt kundmöte och det kan användas även som ett vanligt skrivbord om så behövs.\r\n\r\nPresentationsbord kan vara i olika former, storlekar och utformningar. Det finns inga begränsningar för oss i det avseende. Extra tillbehör som själva skrivbord, penna eller svamp kan förvandla ett vanligt presentationsbord i ett unikt marknadsföringsverktyg.\r\n\r\nPresentationsbord – ett effektivt stöd för presentation av ett företag, produkt, tjänst. ', 'yes', ',prezenter1,prezenter2,prezenter3,prezenter4,'),
(6, 'Provpärmar', 'Inte alla produkter kan presenteras på bilder. Många gånger viktigare än själva bilden är en bra exponering av material, färger, textur. Vi skapar unika och funktionella förpackningar för dina produktprover. Tack vare detta kan din kund inte bara se men även röra och bedöma fördelar av din produkt som inte syns på bilden.\r\n\r\nProvmappar är viktiga verktyg för säljare och distributionsnätverk.\r\n\r\nTa med dig material som du vill visa och vi tar fram en provmapp som motsvarar dina behov. ', 'yes', ',wzornik-tynki2,wzornik-tkanin,wzornik-drewno,wzornik_tynki1,soczewki,wzornik-tynki3,wzornik_wachlarz,wzornik-pudelko,'),
(7, 'Receptblock', 'Ett av våra förslag till medicinbranschen – receptblock. En funktionell mapp med olika möjligheter för förslutning och extra tillbehör, som används för att förvara recept. Ett måste för varje läkare. Ett mycket effektivt verktyg för läkemedelbolag, och samtidigt en mycket praktisk present. ', 'yes', ',receptariusz1,receptariusz2,receptariusz3,receptariusz4,'),
(8, 'Förpackningar för vin och sprit', 'Exklusiva drycker kräver en elegant förpackning. Våra lådor för vin och sprit är ett fantastiskt alternativ för boxar i metall eller trä. Både storlek och tryck kan anpassas vilket ger enorma möjligheter. Det finns tre grundutföranden av lådor för vin och sprit – alla med olika fördelar. En flaska vin eller sprit förpackad i en fin låda är en riktigt elegant gåva. Värdefullt innehåll och spektakulär förpackning skickar en kraftfull signal.', 'yes', ',pudelko1,pudelko2,pudelko3,pudelko4,pudelko5,'),
(9, 'Visitkortshållare', 'Marknadsföringsprodukter, förutom dess roll som reklam, kan även vara mycket användbara. När de hamnar hos kunden kan de leva sitt eget liv och blir en fantastisk reklambärare som identifieras med ett visst företag, märke eller tjänst.\r\n\r\nEn visitkortshållare är ett mycket bra val om du vill ge en praktisk och fin present.', 'yes', ',wizytowniki1,wizytowniki2,wizytowniki3,'),
(10, 'Produkter av polypropen', 'produkter av polypropen', 'no', ',produkty_PP1,produkty_PP2,produkty_PP2a,produkty_PP3,produkty_PP4\r\n,'),
(11, 'Stå för flygblad', 'Stå för flygblad', 'no', ',ulotkownik1,ulotkownik2,');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `produkty`
--

CREATE TABLE IF NOT EXISTS `produkty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa_pl` varchar(256) NOT NULL,
  `opis_pl` text NOT NULL,
  `kategoria` tinytext NOT NULL,
  `branza` tinytext NOT NULL,
  `cechy` tinytext NOT NULL,
  `zdjecia` tinytext NOT NULL,
  `prototyp` tinyint(1) NOT NULL,
  `logowanie` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Zrzut danych tabeli `produkty`
--

INSERT INTO `produkty` (`id`, `nazwa_pl`, `opis_pl`, `kategoria`, `branza`, `cechy`, `zdjecia`, `prototyp`, `logowanie`) VALUES
(1, 'Etui na dokumenty podróży', 'Etui na dokumenty podróży - Prototyp Achilles Polska', '2', '16', '0', '984,985', 0, 0),
(2, 'Teczka na dokumenty samochodu', 'Teczka na dokumenty samochodu - Prototyp Achilles Polska', '2', '10', '1', '982,983', 0, 0),
(3, 'Teczka Peugeot Bank', 'Teczka Peugeot Bank. Dodatkowe elementy: kieszeń sztancowana na dokumenty, gumka zamykająca. ', '2', '10', '1,5', '853,854,855', 0, 0),
(4, 'Teczka Matopat', 'Teczka wielobigowa. Dodatkowe elementy - pudełka z polipropylenu stanowiące boki teczki, mechanizm. ', '2', '9', '3,4', '849,850,851', 0, 0),
(5, 'Teczka Domowe Klimaty', 'Teczka wielobigowa.', '2', '1', '1,6', '847,848', 0, 0),
(6, 'Teczka Citroen Bank', 'Teczka Citroen Bank. Dodatkowe elementy: kieszeń sztancowana na dokumenty, gumka zamykająca.', '2', '5', '1,5', '844,845,846', 0, 0),
(7, 'Teczka CDS GROUP', 'Teczka CDS GROUP.', '2', '3', '1,5', '842,843', 0, 0),
(8, 'Teczka BANK BGŻ', 'Teczka BANK BGŻ. Dodatkowe elementy: zamknięcie na magnes, mechanizm ringowy, wireclip, uchwyt na długopis, notes. ', '2', '5', '1,7', '838,839', 0, 0),
(9, 'Segregator E-szkoła', 'Segregator E-szkoła. Mechanizm R25/04. Dodatkowe wyposażenie: przekładki katalogowe.', '1', '2', '1,8', '217,362,363,364', 0, 0),
(10, 'Segregator Florum/D65', 'Segregator Florum/D65. Mechanizm D65/02. ', '1', '3', '1,5', '304,307,308', 0, 0),
(11, 'Segregator Allianz/D52', 'Segregator Allianz/D52. Mechanizm D52/02. ', '1', '17', '1,5', '310,311,312', 0, 0),
(12, 'Segregator Le Charme', 'Segregator Le Charme.', '1', '11', '9', '330,331,333,334,335,336', 0, 0),
(13, 'Katalog Achilles', 'Segregator z etui oraz kompletem kart katalogowych. Mechanizm D20/03. Dodatkowe elementy: lakierowany mechanizm.', '1', '1', '10', '344,345,347,348,349,350,351', 0, 0),
(14, 'Segregator Bims Plus/D45', 'Segregator Bims Plus/D45. Mechanizm D45/02. ', '1', '1', '1,5', '413,414,415', 0, 0),
(15, 'Segregator Sanplast D40/04', 'Segregator Sanplast D40/04. Mechanizm D40/04. Dodatkowe wyposażenie: kółko na grzbiecie. ', '1', '1', '1,6', '417,418,419', 0, 0),
(16, 'Segregator P&G/D35', 'Segregator P&G/D35. Mechanizm D35/02. Dodatkowe wyposażenie: przekładki katalogowe, kompresor, kieszonka na dokumenty, kieszonka na CD.', '1', '15', '1,10', '421,422,423,424,426', 0, 0),
(17, 'Clipboard Achilles', 'Clipboard Achilles. ', '3', '1', '1,10', '106', 0, 0),
(18, 'Clipboard Interservis', 'Clipboard Interservis, zamykany. Mechanizm: WCL 100, uchwyt na długopis. Grzbiet: wielobig. ', '3', '12', '1,11', '316,317,481', 0, 0),
(19, 'Clipboard zamykany Achilles', 'Clipboard zamykany Achilles. Mechanizm WCL 100, uchwyt na długopis. Grzbiet: wielobig.', '3', '1', '1,12', '470', 0, 0),
(20, 'Clipboard WOŚP', 'Clipboard WOŚP.', '3', '13', '1,11', '800,801', 0, 0),
(21, 'Clipboard PROFI', 'Clipboard PROFI. Dodatkowe elementy - mechanizm lakierowany.', '3', '7', '1,13', '806,807,808', 0, 0),
(22, 'Clipboard SKOK', 'Clipboard SKOK. Dodatkowe elementy - mechanizm, bloczki ze stikerami.', '3', '5', '1,11', '809,810', 0, 0),
(23, 'Pudełko Achilles', 'Pudełko Achilles na dokumenty, płyty CD lub inne kolekcje.', '4', '1', '5', '244', 0, 0),
(24, 'Komplet etui SAPA', 'Komplet 2 etui na materiały reklamowe.', '4', '1', '14', '720,798,799', 0, 0),
(25, 'Etui "Zamachy"', 'Etui na DVD.', '4', '8', '15', '534', 0, 0),
(26, 'Etui Columbo', 'Etui na okładkę do płyt CD/DVD.', '4', '8', '15', '526,527', 0, 0),
(27, 'Prezenter LMI', 'Prezenter LMI. Uszlachetnienie - kalander gruby oklejka, kalander drobny wklejka.', '5', '1', '1,11', '811,812,813', 0, 0),
(28, 'Prezenter - etui na soczewki JZO', 'Prezenter dostosowany formatem do potrzeb klienta. Dodatkowe elementy - zapięcie na magnes, wkładki z pianki na soczewki, kieszeń wklejana. ', '5', '9', '8', '506,507', 0, 0),
(29, 'Prezenter Gala', 'Prezenter dostosowany formatem do potrzeb klienta. Uszlachetnienie - kalander gruby. ', '5', '7', '11', '490,491,494,495', 0, 0),
(30, 'Prezenter Master Card', 'Prezenter dostosowany formatem do potrzeb klienta. Prezenter wyposażony w tablicę do pisania, marker oraz gąbkę. ', '5', '5', '5', '155,319,320,321,339', 0, 0),
(31, 'Etui na soczewki okularowe', 'Etui na soczewki okularowe - Prototyp Achilles Polska', '6', '9', '0', '986,987', 0, 0),
(32, 'PAGED wzornik tkanin', 'Wzornik tkanin. Dodatkowe elementy: dwa mechanizmy do umieszczenia próbek.', '6', '7', '16', '820,821', 0, 0),
(33, 'GINTARO wzornik tkanin', 'Wzornik. Dodatkowe elementy: wkładka z PCV spienionego - wieszak.', '6', '7', '17', '770,771,772', 0, 0),
(34, 'Wzornik GLASS MIX', 'Wzornik, format specjalny. Druk 4/4, błyszczący ,kalander. Dodatkowe elementy: zakładki zabezpieczające', '6', '1', '18', '694,695,701', 0, 0),
(35, 'Okładka na zwolnienia L4 Advantan', 'Okładka na zwolnienia lekarskie L4. Zastosowano gumkę zamykającą oraz przekładkę zapobiegającą samokopiowaniu. Mechanizm WCL 100. ', '7', '4', '10', '792,795', 0, 0),
(36, 'Okładka na zwolnienia L4 Pharma Nord', 'Okładka na zwolnienia lekarskie L4. Dodatkowe elementy: gumka zamykająca oraz przekładka, mechanizm WCL100.', '7', '4', '10', '550,551,552', 0, 0),
(37, 'Receptariusz Spuriva', 'Okładka na recepty (receptariusz). Zastosowano gumkę zamykającą. Mechanizm WL 100.', '7', '9', '11', '96,358,359', 0, 0),
(38, 'Okładka na zwolnienia L4 Aspirin', 'Okładka na zwolnienia lekarskie L4. Zastosowano gumkę zamykającą oraz przekładkę zapobiegającą samokopiowaniu. Mechanizm WCL 100.', '7', '4', '10', '88,355,356,357', 0, 0),
(39, 'Pudełko na wino pionowe z klapką', 'Pudełko na wino pionowe z klapką - Prototyp Achilles Polska.', '8', '1', '0', '976,977,978,979', 1, 0),
(40, 'Pudełko na wino z przykrywką z okienkiem', 'Pudełko na wino pionowe z przykrywką z okienkiem - Prototyp Achilles Polska.', '8', '1', '0', '980', 1, 0),
(41, 'Pudełko na wino - tuba', 'Pudełko na wino pionowe w formie tuby - Prototyp Achilles Polska.', '8', '1', '0', '981', 1, 0),
(42, 'Teczka DRE', 'Teczka - wzornik szkła. Dodatkowe elementy - wzmocnienie ścianki tylnej. ', '2', '1', '8', '827,828,829', 0, 0),
(43, 'Segregator Philips/D30', 'Segregator Philips/D30. Mechanizm D30/02. Dodatkowe wyposażenie: kompresor. ', '1', '3', '1,11', '439,440,441', 0, 0),
(44, 'Segregator Gaspol/D25', 'Segregator Gaspol/D25. Mechanizm D25/02. ', '1', '1', '1,15', '443,445,447', 0, 0),
(45, 'Segregator Rintal/D20', 'Segregator Rintal/D20. Mechanizm D20/02.', '1', '1', '1,5', '449,450,451', 0, 0),
(46, 'Segregator Porta/D16', 'Segregator Porta/D16Segregator, format A4. Druk 4/0, folia matowa. Mechanizm D16/02. ', '1', '1', '1,8', '452,453,454', 0, 0),
(47, 'Segregator Warta/D16', 'Segregator Warta/D16 format A4. Druk 4/0, folia matowa. Mechanizm D16/02. ', '1', '17', '1,8', '455,456,457', 0, 0),
(48, 'Segregator Achilles', 'Segregator z mechanizmem dźwigniowym. Mechanizm F75. Zastosowano kółko na grzbiecie i zapięcie RADO.', '1', '1', '19', '500,501', 0, 0),
(49, 'Segregator Muraspec', 'Segregator Muraspec. Mechanizm D65/02. Oklejany tkaniną. Dodatkowy element - sitodruk.', '1', '1', '0', '521,522', 0, 0),
(50, 'Segregator Famos', 'Segregator Famos. Dodatkowe elementy - lakier UV, grzbiet wielobigowy .', '1', '7', '1,10', '816,817', 0, 0),
(51, 'Segregator Warta Smok', 'Segregator Warta Smok.', '1', '17', '15', '822,823', 0, 0),
(52, 'Segregator BRW', 'Segregator "poziomy" z mechanizmem. Specjalny format tektury.', '1', '7', '8', '814,815', 0, 0),
(53, 'Segregator Paged', 'Segregator Paged. Dodatkowe elementy - 2 kieszenie na CD.', '1', '7', '1,8', '818,819', 0, 0),
(54, 'Teczka Archon', 'Teczka Archon', '2', '1', '1,8', '832,834,837', 0, 0),
(55, 'Teczka LOTOS', 'Teczka LOTOS. Dodatkowe elementy: plastikowe boczki.', '2', '14', '1,20', '830,831', 0, 0),
(56, 'Teczka Converse', 'Teczka Converse. Dodatkowe elementy: plastikowe boki, gumka.', '2', '11', '1,10', '824,825', 0, 0),
(57, 'Okładka Gdańsk 2000', 'Okładka Gdańsk 2000. Dodatkowy element - zapięcie na magnes.', '2', '13', '21', '802,803,805', 0, 0),
(58, 'Teczka testowy', 'Teczka testowy. Dodatkowe elementy: plastikowe boki, gumka.', '2', '1', '1,10', '784,786,787,788,789,790,791', 0, 0),
(59, 'Teczka Amgen', 'Teczka Amgen. Dodatkowe elementy: kieszenie sztancowane na dokumenty.', '2', '9', '1,8', '565,566', 0, 0),
(60, 'Teczka Polskie Radio', 'Teczka Polskie Radio. Dodatkowe elementy: magnesy zamykające.', '2', '8', '1,16', '594,595,597', 0, 0),
(61, 'Teczka Paged', 'Teczka z rączką. Dodatkowe elementy: lakier punktowy UV.', '2', '7', '8', '572,573,577', 0, 0),
(62, 'Teczka harmonijkowa Bank Pocztowy', 'Teczka harmonijkowa Bank Pocztowy. Dodatkowe elementy: przekładki z registrami.', '2', '5', '1,8', '561,562', 0, 0),
(63, 'Teczka LOTOS', 'Teczka LOTOS. Dodatkowe elementy: mechanizm dźwigniowy.', '2', '14', '1,8', '540,542,544', 0, 0),
(64, 'Teczka Tikkurila', 'Teczka Tikkurila. Dodatkowe elementy: przegroda tekturowa, wkładka z pianki PE.', '2', '1', '1,22', '515,516', 0, 0),
(65, 'Clipboard', 'Clipboard', '3', '2', '1,10', '781,782', 0, 0),
(66, 'Pudełko Porta', 'Pudełko na dokumenty lub próbki. Zastosowano plastikowe narożniki.', '4', '1', '8', '99,352', 0, 0),
(67, 'Pudełko Achilles', 'Pudełko na płyty CD, karty lub inne kolekcje.', '4', '1', '5', '103,353,354', 0, 0),
(68, 'Etui Święty', 'Etui na okładkę do płyt CD/DVD.', '4', '8', '15', '137,337,338', 0, 0),
(69, 'Etui Le Charme', 'Etui na segregator.', '4', '11', '19', '135,324,325,326,327,328', 0, 0),
(70, 'Etui Achilles', 'Etui na segregator.', '4', '1', '8', '250,340,341,342', 0, 0),
(71, 'Wzornik Ceramika Gres', 'Wzornik, format specjalny. Dodatkowe elementy: przekładka zabezpieczająca. ', '6', '1', '23', '172,410,411,412', 0, 0),
(72, 'Wzornik', 'Wzornik. Dodatkowe elementy: wkładka piankowa do umieszczenia próbek.', '6', '1', '17', '174', 0, 0),
(73, 'Wzornik Kabe', 'Wzornik tynków.', '6', '1', '19', '164,408,409', 0, 0),
(74, 'Wizytownik ', 'Wizytownik Achilles. Mechanizm R20/04. Dodatkowe elementy: kieszonki na wizytówki, skorowidz. ', '9', '1', '24', '460,508', 0, 0),
(75, 'Wizytownik Archon', 'Wizytownik Archon. Mechanizm: R20/04. Dodatkowe elementy: kieszonki na wizytówki, skorowidz. ', '9', '1', '16', '129,406,407', 0, 0),
(76, 'Teczka', 'Teczka z polipropylenu', '10', '1', '1', 'produkty_PP1,produkty_PP1', 0, 0),
(77, 'Stojak na ulotki Archon', 'Stojak na ulotki Archon', '11', '1', '1', 'ulotkownik1,ulotkownik1', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `produkty_en`
--

CREATE TABLE IF NOT EXISTS `produkty_en` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `kategoria` tinytext NOT NULL,
  `branza` tinytext NOT NULL,
  `cechy` tinytext NOT NULL,
  `zdjecia` tinytext NOT NULL,
  `prototyp` tinyint(1) NOT NULL,
  `logowanie` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Zrzut danych tabeli `produkty_en`
--

INSERT INTO `produkty_en` (`id`, `nazwa`, `opis`, `kategoria`, `branza`, `cechy`, `zdjecia`, `prototyp`, `logowanie`) VALUES
(1, 'Etui na dokumenty podróży', 'Etui na dokumenty podróży - Prototyp Achilles Polska', '2', '16', '0', ',984,985,', 0, 0),
(2, 'Teczka na dokumenty samochodu', 'Teczka na dokumenty samochodu - Prototyp Achilles Polska', '2', '10', '1', ',982,983,', 0, 0),
(3, 'Peugeot Bank folder', 'Peugeot Bank folder, A4 format.Print 4/0, glossy finish.Accessories:die-cut pocket for documents, rubber band closure.', '2', '10', '1,5', ',853,854,855,', 0, 0),
(4, 'Matopat folder ', 'folder, multibend 480x300x90 mmformatPrint 3/0 special matt finishAccessories -  polypropylene sides, rings .', '2', '9', '3,4', ',849,850,851,', 0, 0),
(5, 'Domowe Klimaty folder', 'folder, multibend A4 format.Print 2/0 matt finish', '2', '1', '1,6', ',847,848,', 0, 0),
(6, 'Citroen Bank folder', 'Citroen Bank folder, A4 format.Print 4/0, glossy finish.Accessories:die-cut pocket for documents, rubber band closure.', '2', '5', '1,5', ',844,845,846,', 0, 0),
(7, 'CDS GROUP folder', 'folder, A4 format.Print 4/0 glossy finish', '2', '3', '1,5', ',842,843,', 0, 0),
(8, 'BGZ Bank folder', 'folder, A4 format.Print 4/4, matt finish, UV varnish.Accessories: ring, magnet closure,wireclip, pen holder, notebook .', '2', '5', '1,7', ',838,839,', 0, 0),
(9, 'E-szkoła ring binder', 'ring binder, A4 format.Print 4/0, matt finish.Ring R25/04.Accessories: index tabs.', '1', '2', '1,8', ',217,362,363,364,', 0, 0),
(10, 'Florum ring binder / D65', 'ring binder, A4 format.Print 4/0, glossy finish.Ring D65/02.', '1', '3', '1,5', ',304,307,308,', 0, 0),
(11, 'Allianz ring binder  / D52', 'ring binder, A4 format.Print 4/0, glossy finish.Ring D52/02.', '1', '17', '1,5', ',310,311,312,', 0, 0),
(12, 'Le Charme ring binder', 'ring binder, special format.Print 4/4, patterned glossy finish.', '1', '11', '9', ',330,331,333,334,335,336,', 0, 0),
(13, 'Achilles catalogue', 'ring binder with a slipcase and index tabs.Print 4/4, matt finish.Ring D20/03Accessories: powder coated Ring.', '1', '1', '10', ',344,345,347,348,349,350,351,', 0, 0),
(14, 'Bims Plus ring binder / D45', 'ring binder, A4 format.Print 4/0, glossy finish.Ring  D45/02.', '1', '1', '1,5', ',413,414,415,', 0, 0),
(15, 'Sanplast ring binder / D40/04', 'ring binder, A4 format.Print 2/0, matt finish.Ring D40/04.Accessories: metal hole.', '1', '1', '1,6', ',417,418,419,', 0, 0),
(16, ' P&amp;G ring binder / D35', 'ring binder, A4 format.Print 4/4, matt finish.Ring D35/02.Accessories: index tabs, wire compressor,CD and documents pockets.', '1', '15', '1,10', ',421,422,423,424,426,', 0, 0),
(17, 'Achilles clipboard', 'clipboard, format  A4. Print 4/4, matt finish.', '3', '1', '1,10', ',106,', 0, 0),
(18, 'Interservis clipboard', 'folded clipboard, A4 format.Print 4/4, glossy finish.Ring: WCL 100, pen holderBack: multibend.', '3', '12', '1,11', ',316,317,481,', 0, 0),
(19, 'Achilles clipboard', 'clipboard with a fold, A4 format. Print 4/4, patterned glossy finish, UV varnish.Ring WCL 100, pen holder.Multibend ridge.', '3', '1', '1,12', ',470,', 0, 0),
(20, 'WOSP clipboard', 'Clipboard, format  A4. Print 4/4, glossy finish', '3', '13', '1,11', ',800,801,', 0, 0),
(21, 'PROFI clipboard  ', 'Clipboard, A4 format. Print 4/4, matt finish, glossy UV varnish.Accessories - powder coated rings.', '3', '7', '1,13', ',806,807,808,', 0, 0),
(22, 'SKOK clipboard', 'clipboard, format  A4. Print 4/4, glossy finish.Accessories - rings, sticky notes', '3', '5', '1,11', ',809,810,', 0, 0),
(23, 'box Achilles', 'box for documents, CDs or other collections.Print 4/0, glossy finish.', '4', '1', '5', ',244,', 0, 0),
(24, 'SAPA set of cases', 'set of 2 cases for promotional materials.Print 2/0 - silver, black, special matt finish,', '4', '1', '14', ',720,798,799,', 0, 0),
(25, '&quot;Zamachy&quot; slipcase', 'slipcase for DVD Print 4/0 , matt finish, UV varnish.', '4', '8', '15', ',534,', 0, 0),
(26, 'Columbo slipcase', 'slipcase for CD/DVD.Print 4/0, matt finish, UV varnish', '4', '8', '15', ',526,527,', 0, 0),
(27, 'LMI easel binder', 'easel binder A4 Print 4/4, glossy finish, embossing', '5', '1', '1,11', ',811,812,813,', 0, 0),
(28, 'Prezenter - etui na soczewki JZO', 'Prezenter dostosowany formatem do potrzeb klienta. Dodatkowe elementy - zapięcie na magnes, wkładki z pianki na soczewki, kieszeń wklejana. ', '5', '9', '8', ',506,507,', 0, 0),
(29, 'Gala easel binder', 'easel binder, custom format.Print 4/4, glossy finish, paper finish - thick embossing.', '5', '7', '11', ',490,491,494,495,', 0, 0),
(30, 'Master Card easel binder', 'custom-made easel binder.Print 4/0, glossy finish.Easel binder with whiteboard, marker and sponge.', '5', '5', '5', ',155,319,320,321,339,', 0, 0),
(31, 'Etui na soczewki okularowe', 'Etui na soczewki okularowe - Prototyp Achilles Polska', '6', '9', '0', ',986,987,', 0, 0),
(32, 'PAGED sample folder for fabrics', 'sample folder for fabricsPrint 4/0, laminat matowy.Accessories: two rings for samples.', '6', '7', '16', ',820,821,', 0, 0),
(33, 'GINTARO sample folder for fabrics', 'sample folderPrint 4/0, glossy laminate.Accessories:PCV hanger', '6', '7', '17', ',770,771,772,', 0, 0),
(34, 'GLASS MIX sample folder', 'sample folder, special format.Print 4/4, glossy ,embossing.Accessories: protective folds.', '6', '1', '18', ',694,695,701,', 0, 0),
(35, 'Advantan folder for sick leave forms', 'folder for sick leave forms.Print 4/4, matt finish.Elastic band closure and separator against self-copying.Rings WCL 100.', '2', '', '', ',792,795,', 0, 0),
(36, 'Pharma Nord folder for sick leave forms', 'Folder for sick leave forms.Print 4/4, matt finish.Accessories : rubber band closure, separator, WCL100 ring', '2', '', '', ',550,551,552,', 0, 0),
(37, 'Spuriva prescription folder', 'prescription folderPrint 4/4, glossy finish.With elastic band closure.Ring WL 100.', '7', '9', '11', ',96,358,359,', 0, 0),
(38, 'Aspirin folder for sick leave forms', 'folder for sick leave forms.Print 4/4, matt finish.With elastic band closure and separator against self-copying.Ring WCL 100.', '7', '4', '10', ',88,355,356,357,', 0, 0),
(39, 'Wine box with a flap', 'Wine box with a flap - Achilles Polska Prototype', '8', '1', '0', ',976,977,978,979,', 1, 0),
(40, 'Stand-up wine box with window lid', 'Stand-up wine box with window lid - Achilles Polska Prototype', '8', '1', '0', ',980,', 1, 0),
(41, 'Tube-shaped wine box', 'Tube-shaped stand-up box for wine or spirits - Achilles Polska Prototype', '8', '1', '0', ',981,', 1, 0),
(42, 'DRE folder', 'sample folder for glassPrint 4/0 matt finish Accessories -  strengthened back.', '2', '1', '8', ',827,828,829,', 0, 0),
(43, 'Philips ring binder / D30', 'ring binder, A4 format.Print 4/4, glossy finish.Ring D30/02.Accessories: wire compressor.', '1', '3', '1,11', ',439,440,441,', 0, 0),
(44, 'Gaspol ring binder / D25', 'ring binder, A4 format.Print 4/0, matt finish, UV varnish.Ring D25/02.', '1', '1', '1,15', ',443,445,447,', 0, 0),
(45, 'Rintal ring binder / D20', 'ring binder, A4 format.Print 4/0, glossy finish.Ring D20/02.', '1', '1', '1,5', ',449,450,451,', 0, 0),
(46, 'Porta ring binder / D16', 'ring binder, A4 format.Print 4/0, matt finish.Ring D16/02.', '1', '1', '1,8', ',452,453,454,', 0, 0),
(47, 'Warta ring binder / D16', 'ring binder, A4 format.Print 4/0, matt finish.Ring D16/02.', '1', '17', '1,8', ',455,456,457,', 0, 0),
(48, 'Achilles ring binder', 'ring binder with arch ring.Print 4/0, patterned glossy finish.Ring F75.With RADO holes.', '1', '1', '19', ',500,501,', 0, 0),
(49, 'ring binder Muraspec', 'ring binder, ring D65/02.Fabric covered,Additional element - Screen printing', '1', '1', '0', ',521,522,', 0, 0),
(50, 'Famos ring binder', 'ring binder, A4 format.Print 4/4, matt finish.Accessories - UV varnish, multibend', '1', '7', '1,10', ',816,817,', 0, 0),
(51, 'Warta Smok ring binder', 'ring binder Print 4/0, matt finish,UV varnish', '1', '17', '15', ',822,823,', 0, 0),
(52, 'BRW ring binder', 'horizontal ring binder Print 4/0, matt finish, special format', '1', '7', '8', ',814,815,', 0, 0),
(53, 'Paged ring binder ', 'ring binder A4 format Print 4/0 matt finish Accessories - 2 die-cut pockets for CD', '1', '7', '1,8', ',818,819,', 0, 0),
(54, 'Archon folder', 'folder, A4 format.Print 4/0, matt finish', '2', '1', '1,8', ',832,834,837,', 0, 0),
(55, 'LOTOS folder', 'folder, A4 format.Print 5/1 matt finishAccessories: plastic sides', '2', '14', '1,20', ',830,831,', 0, 0),
(56, 'Converse folder', 'folder, A4 format.Print 4/4, matt finishAccessories: plastic sides, elastic band', '2', '11', '1,10', ',824,825,', 0, 0),
(57, 'Gdańsk 2000 folder', 'Gdańsk 2000 folderPrint 5/5, gold. Glossy finish.Accessories - magnet closure.', '2', '13', '21', ',802,803,805,', 0, 0),
(58, 'Teczka testowy', 'Teczka testowy. Dodatkowe elementy: plastikowe boki, gumka.', '2', '1', '1,10', ',784,786,787,788,789,790,791,', 0, 0),
(59, 'Amgen folder', 'folder Amgen, A4 format.Print 4/0, matt finish.Accessories: pocket for documents.', '2', '9', '1,8', ',565,566,', 0, 0),
(60, 'Polish Radio folder', 'folder, A4 format.Print 4/0,matt laminate.Accessories: magnet closure.', '2', '8', '1,16', ',594,595,597,', 0, 0),
(61, 'Paged folder', 'folder with handle, Print 4/0, matt finish.Accessories: spot UV varnish', '2', '7', '8', ',572,573,577,', 0, 0),
(62, 'Bank Pocztowy accordion folder', 'accordion folder, A4 format.Print 4/0, matt finish.Accessories: separators with index tabs', '2', '5', '1,8', ',561,562,', 0, 0),
(63, 'LOTOS folder', 'folder, A4 format.Print 4/0 matt finishAccessories: arch ring', '2', '14', '1,8', ',540,542,544,', 0, 0),
(64, 'Tikkurila folder', 'folder, A4 format.Print 4/4, glossy finish kalandrowanaAccessories: przegroda tekturowa, wkładka z pianki PE', '2', '1', '1,22', ',515,516,', 0, 0),
(66, 'box Porta', 'box for documents or samples.Print 4/0, matt finish.With plastic corners.', '4', '1', '8', ',99,352,', 0, 0),
(67, 'box Achilles', 'box for CDs, cards or other collections.Print 4/0, glossy finish.', '4', '1', '5', ',103,353,354,', 0, 0),
(68, 'The Saint slipcase', 'slipcase for CD/DVD.Print 4/0, matt finish, UV varnish', '4', '8', '15', ',137,337,338,', 0, 0),
(69, 'Le Charme slipcase', 'slipcase for ring binder.Print 4/0 , patterned glossy finish.', '4', '11', '19', ',135,324,325,326,327,328,', 0, 0),
(70, 'Achilles slipcase', 'ring binder slipcase. Print 4/0, matt finish.', '4', '1', '8', ',250,340,341,342,', 0, 0),
(71, 'Ceramika Gres sample folder', 'sample folder, special format.Print 4/4, matt laminate.Accessories: separator.', '6', '1', '23', ',172,410,411,412,', 0, 0),
(72, 'sample folder', 'sample folderPrint 4/0, gloss laminate.Accessories: polyurethane foam pad for samples.', '6', '1', '17', ',174,', 0, 0),
(73, 'Kabe sample folder', 'sample folder for plaster.Print 4/0, patterned glossy finish.', '6', '1', '19', ',164,408,409,', 0, 0),
(74, 'Achilles business card folder', 'business card folderPrint 4/4, various laminates, UV convex varnish.Ring R20/04Accessories: business cards pockets, index tabs.', '9', '1', '24', ',460,508,', 0, 0),
(75, 'business card  Archon', 'business card folder Print 4/0, matte laminate.Ring: R20/04Accessories: business card pockets, index tabs.', '9', '', '', ',129,406,407,', 0, 0),
(76, 'Polypropylen folder', '', '10', '', '', ',produkty_PP1,produkty_PP1,', 0, 0),
(77, 'Leaflet dispensers', '', '11', '', '', ',ulotkownik1,ulotkownik1,', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `produkty_no`
--

CREATE TABLE IF NOT EXISTS `produkty_no` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `kategoria` tinytext NOT NULL,
  `branza` tinytext NOT NULL,
  `cechy` tinytext NOT NULL,
  `zdjecia` tinytext NOT NULL,
  `prototyp` tinyint(1) NOT NULL,
  `logowanie` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Zrzut danych tabeli `produkty_no`
--

INSERT INTO `produkty_no` (`id`, `nazwa`, `opis`, `kategoria`, `branza`, `cechy`, `zdjecia`, `prototyp`, `logowanie`) VALUES
(1, 'Etui na dokumenty podróży', 'Etui na dokumenty podróży - Prototyp Achilles Polska', '2', '16', '0', ',984,985,', 0, 0),
(2, 'Teczka na dokumenty samochodu', 'Teczka na dokumenty samochodu - Prototyp Achilles Polska', '2', '10', '1', ',982,983,', 0, 0),
(3, 'Peugeot Bank folder', 'Peugeot Bank folder, A4 format.Print 4/0, glossy finish.Accessories:die-cut pocket for documents, rubber band closure.', '2', '10', '1,5', ',853,854,855,', 0, 0),
(4, 'Matopat folder ', 'folder, multibend 480x300x90 mmformatPrint 3/0 special matt finishAccessories -  polypropylene sides, rings .', '2', '9', '3,4', ',849,850,851,', 0, 0),
(5, 'Domowe Klimaty folder', 'folder, multibend A4 format.Print 2/0 matt finish', '2', '1', '1,6', ',847,848,', 0, 0),
(6, 'Citroen Bank folder', 'Citroen Bank folder, A4 format.Print 4/0, glossy finish.Accessories:die-cut pocket for documents, rubber band closure.', '2', '5', '1,5', ',844,845,846,', 0, 0),
(7, 'CDS GROUP folder', 'folder, A4 format.Print 4/0 glossy finish', '2', '3', '1,5', ',842,843,', 0, 0),
(8, 'BGZ Bank folder', 'folder, A4 format.Print 4/4, matt finish, UV varnish.Accessories: ring, magnet closure,wireclip, pen holder, notebook .', '2', '5', '1,7', ',838,839,', 0, 0),
(9, 'E-szkoła ring binder', 'ring binder, A4 format.Print 4/0, matt finish.Ring R25/04.Accessories: index tabs.', '1', '2', '1,8', ',217,362,363,364,', 0, 0),
(10, 'Florum ring binder / D65', 'ring binder, A4 format.Print 4/0, glossy finish.Ring D65/02.', '1', '3', '1,5', ',304,307,308,', 0, 0),
(11, 'Allianz ring binder  / D52', 'ring binder, A4 format.Print 4/0, glossy finish.Ring D52/02.', '1', '17', '1,5', ',310,311,312,', 0, 0),
(12, 'Le Charme ring binder', 'ring binder, special format.Print 4/4, patterned glossy finish.', '1', '11', '9', ',330,331,333,334,335,336,', 0, 0),
(13, 'Achilles catalogue', 'ring binder with a slipcase and index tabs.Print 4/4, matt finish.Ring D20/03Accessories: powder coated Ring.', '1', '1', '10', ',344,345,347,348,349,350,351,', 0, 0),
(14, 'Bims Plus ring binder / D45', 'ring binder, A4 format.Print 4/0, glossy finish.Ring  D45/02.', '1', '1', '1,5', ',413,414,415,', 0, 0),
(15, 'Sanplast ring binder / D40/04', 'ring binder, A4 format.Print 2/0, matt finish.Ring D40/04.Accessories: metal hole.', '1', '1', '1,6', ',417,418,419,', 0, 0),
(16, ' P&amp;G ring binder / D35', 'ring binder, A4 format.Print 4/4, matt finish.Ring D35/02.Accessories: index tabs, wire compressor,CD and documents pockets.', '1', '15', '1,10', ',421,422,423,424,426,', 0, 0),
(17, 'Achilles clipboard', 'clipboard, format  A4. Print 4/4, matt finish.', '3', '1', '1,10', ',106,', 0, 0),
(18, 'Interservis clipboard', 'folded clipboard, A4 format.Print 4/4, glossy finish.Ring: WCL 100, pen holderBack: multibend.', '3', '12', '1,11', ',316,317,481,', 0, 0),
(19, 'Achilles clipboard', 'clipboard with a fold, A4 format. Print 4/4, patterned glossy finish, UV varnish.Ring WCL 100, pen holder.Multibend ridge.', '3', '1', '1,12', ',470,', 0, 0),
(20, 'WOSP clipboard', 'Clipboard, format  A4. Print 4/4, glossy finish', '3', '13', '1,11', ',800,801,', 0, 0),
(21, 'PROFI clipboard  ', 'Clipboard, A4 format. Print 4/4, matt finish, glossy UV varnish.Accessories - powder coated rings.', '3', '7', '1,13', ',806,807,808,', 0, 0),
(22, 'SKOK clipboard', 'clipboard, format  A4. Print 4/4, glossy finish.Accessories - rings, sticky notes', '3', '5', '1,11', ',809,810,', 0, 0),
(23, 'box Achilles', 'box for documents, CDs or other collections.Print 4/0, glossy finish.', '4', '1', '5', ',244,', 0, 0),
(24, 'SAPA set of cases', 'set of 2 cases for promotional materials.Print 2/0 - silver, black, special matt finish,', '4', '1', '14', ',720,798,799,', 0, 0),
(25, '&quot;Zamachy&quot; slipcase', 'slipcase for DVD Print 4/0 , matt finish, UV varnish.', '4', '8', '15', ',534,', 0, 0),
(26, 'Columbo slipcase', 'slipcase for CD/DVD.Print 4/0, matt finish, UV varnish', '4', '8', '15', ',526,527,', 0, 0),
(27, 'LMI easel binder', 'easel binder A4 Print 4/4, glossy finish, embossing', '5', '1', '1,11', ',811,812,813,', 0, 0),
(28, 'Prezenter - etui na soczewki JZO', 'Prezenter dostosowany formatem do potrzeb klienta. Dodatkowe elementy - zapięcie na magnes, wkładki z pianki na soczewki, kieszeń wklejana. ', '5', '9', '8', ',506,507,', 0, 0),
(29, 'Gala easel binder', 'easel binder, custom format.Print 4/4, glossy finish, paper finish - thick embossing.', '5', '7', '11', ',490,491,494,495,', 0, 0),
(30, 'Master Card easel binder', 'custom-made easel binder.Print 4/0, glossy finish.Easel binder with whiteboard, marker and sponge.', '5', '5', '5', ',155,319,320,321,339,', 0, 0),
(31, 'Etui na soczewki okularowe', 'Etui na soczewki okularowe - Prototyp Achilles Polska', '6', '9', '0', ',986,987,', 0, 0),
(32, 'PAGED sample folder for fabrics', 'sample folder for fabricsPrint 4/0, laminat matowy.Accessories: two rings for samples.', '6', '7', '16', ',820,821,', 0, 0),
(33, 'GINTARO sample folder for fabrics', 'sample folderPrint 4/0, glossy laminate.Accessories:PCV hanger', '6', '7', '17', ',770,771,772,', 0, 0),
(34, 'GLASS MIX sample folder', 'sample folder, special format.Print 4/4, glossy ,embossing.Accessories: protective folds.', '6', '1', '18', ',694,695,701,', 0, 0),
(35, 'Advantan folder for sick leave forms', 'folder for sick leave forms.Print 4/4, matt finish.Elastic band closure and separator against self-copying.Rings WCL 100.', '2', '', '', ',792,795,', 0, 0),
(36, 'Pharma Nord folder for sick leave forms', 'Folder for sick leave forms.Print 4/4, matt finish.Accessories : rubber band closure, separator, WCL100 ring', '2', '', '', ',550,551,552,', 0, 0),
(37, 'Spuriva prescription folder', 'prescription folderPrint 4/4, glossy finish.With elastic band closure.Ring WL 100.', '7', '9', '11', ',96,358,359,', 0, 0),
(38, 'Aspirin folder for sick leave forms', 'folder for sick leave forms.Print 4/4, matt finish.With elastic band closure and separator against self-copying.Ring WCL 100.', '7', '4', '10', ',88,355,356,357,', 0, 0),
(39, 'Wine box with a flap', 'Wine box with a flap - Achilles Polska Prototype', '8', '1', '0', ',976,977,978,979,', 1, 0),
(40, 'Stand-up wine box with window lid', 'Stand-up wine box with window lid - Achilles Polska Prototype', '8', '1', '0', ',980,', 1, 0),
(41, 'Tube-shaped wine box', 'Tube-shaped stand-up box for wine or spirits - Achilles Polska Prototype', '8', '1', '0', ',981,', 1, 0),
(42, 'DRE folder', 'sample folder for glassPrint 4/0 matt finish Accessories -  strengthened back.', '2', '1', '8', ',827,828,829,', 0, 0),
(43, 'Philips ring binder / D30', 'ring binder, A4 format.Print 4/4, glossy finish.Ring D30/02.Accessories: wire compressor.', '1', '3', '1,11', ',439,440,441,', 0, 0),
(44, 'Gaspol ring binder / D25', 'ring binder, A4 format.Print 4/0, matt finish, UV varnish.Ring D25/02.', '1', '1', '1,15', ',443,445,447,', 0, 0),
(45, 'Rintal ring binder / D20', 'ring binder, A4 format.Print 4/0, glossy finish.Ring D20/02.', '1', '1', '1,5', ',449,450,451,', 0, 0),
(46, 'Porta ring binder / D16', 'ring binder, A4 format.Print 4/0, matt finish.Ring D16/02.', '1', '1', '1,8', ',452,453,454,', 0, 0),
(47, 'Warta ring binder / D16', 'ring binder, A4 format.Print 4/0, matt finish.Ring D16/02.', '1', '17', '1,8', ',455,456,457,', 0, 0),
(48, 'Achilles ring binder', 'ring binder with arch ring.Print 4/0, patterned glossy finish.Ring F75.With RADO holes.', '1', '1', '19', ',500,501,', 0, 0),
(49, 'ring binder Muraspec', 'ring binder, ring D65/02.Fabric covered,Additional element - Screen printing', '1', '1', '0', ',521,522,', 0, 0),
(50, 'Famos ring binder', 'ring binder, A4 format.Print 4/4, matt finish.Accessories - UV varnish, multibend', '1', '7', '1,10', ',816,817,', 0, 0),
(51, 'Warta Smok ring binder', 'ring binder Print 4/0, matt finish,UV varnish', '1', '17', '15', ',822,823,', 0, 0),
(52, 'BRW ring binder', 'horizontal ring binder Print 4/0, matt finish, special format', '1', '7', '8', ',814,815,', 0, 0),
(53, 'Paged ring binder ', 'ring binder A4 format Print 4/0 matt finish Accessories - 2 die-cut pockets for CD', '1', '7', '1,8', ',818,819,', 0, 0),
(54, 'Archon folder', 'folder, A4 format.Print 4/0, matt finish', '2', '1', '1,8', ',832,834,837,', 0, 0),
(55, 'LOTOS folder', 'folder, A4 format.Print 5/1 matt finishAccessories: plastic sides', '2', '14', '1,20', ',830,831,', 0, 0),
(56, 'Converse folder', 'folder, A4 format.Print 4/4, matt finishAccessories: plastic sides, elastic band', '2', '11', '1,10', ',824,825,', 0, 0),
(57, 'Gdańsk 2000 folder', 'Gdańsk 2000 folderPrint 5/5, gold. Glossy finish.Accessories - magnet closure.', '2', '13', '21', ',802,803,805,', 0, 0),
(58, 'Teczka testowy', 'Teczka testowy. Dodatkowe elementy: plastikowe boki, gumka.', '2', '1', '1,10', ',784,786,787,788,789,790,791,', 0, 0),
(59, 'Amgen folder', 'folder Amgen, A4 format.Print 4/0, matt finish.Accessories: pocket for documents.', '2', '9', '1,8', ',565,566,', 0, 0),
(60, 'Polish Radio folder', 'folder, A4 format.Print 4/0,matt laminate.Accessories: magnet closure.', '2', '8', '1,16', ',594,595,597,', 0, 0),
(61, 'Paged folder', 'folder with handle, Print 4/0, matt finish.Accessories: spot UV varnish', '2', '7', '8', ',572,573,577,', 0, 0),
(62, 'Bank Pocztowy accordion folder', 'accordion folder, A4 format.Print 4/0, matt finish.Accessories: separators with index tabs', '2', '5', '1,8', ',561,562,', 0, 0),
(63, 'LOTOS folder', 'folder, A4 format.Print 4/0 matt finishAccessories: arch ring', '2', '14', '1,8', ',540,542,544,', 0, 0),
(64, 'Tikkurila folder', 'folder, A4 format.Print 4/4, glossy finish kalandrowanaAccessories: przegroda tekturowa, wkładka z pianki PE', '2', '1', '1,22', ',515,516,', 0, 0),
(66, 'box Porta', 'box for documents or samples.Print 4/0, matt finish.With plastic corners.', '4', '1', '8', ',99,352,', 0, 0),
(67, 'box Achilles', 'box for CDs, cards or other collections.Print 4/0, glossy finish.', '4', '1', '5', ',103,353,354,', 0, 0),
(68, 'The Saint slipcase', 'slipcase for CD/DVD.Print 4/0, matt finish, UV varnish', '4', '8', '15', ',137,337,338,', 0, 0),
(69, 'Le Charme slipcase', 'slipcase for ring binder.Print 4/0 , patterned glossy finish.', '4', '11', '19', ',135,324,325,326,327,328,', 0, 0),
(70, 'Achilles slipcase', 'ring binder slipcase. Print 4/0, matt finish.', '4', '1', '8', ',250,340,341,342,', 0, 0),
(71, 'Ceramika Gres sample folder', 'sample folder, special format.Print 4/4, matt laminate.Accessories: separator.', '6', '1', '23', ',172,410,411,412,', 0, 0),
(72, 'sample folder', 'sample folderPrint 4/0, gloss laminate.Accessories: polyurethane foam pad for samples.', '6', '1', '17', ',174,', 0, 0),
(73, 'Kabe sample folder', 'sample folder for plaster.Print 4/0, patterned glossy finish.', '6', '1', '19', ',164,408,409,', 0, 0),
(74, 'Achilles business card folder', 'business card folderPrint 4/4, various laminates, UV convex varnish.Ring R20/04Accessories: business cards pockets, index tabs.', '9', '1', '24', ',460,508,', 0, 0),
(75, 'business card  Archon', 'business card folder Print 4/0, matte laminate.Ring: R20/04Accessories: business card pockets, index tabs.', '9', '', '', ',129,406,407,', 0, 0),
(76, 'Polypropylen folder', '', '10', '', '', ',produkty_PP1,produkty_PP1,', 0, 0),
(77, 'Leaflet dispensers', '', '11', '', '', ',ulotkownik1,ulotkownik1,', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `produkty_no_old`
--

CREATE TABLE IF NOT EXISTS `produkty_no_old` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `kategoria` tinytext NOT NULL,
  `branza` tinytext NOT NULL,
  `cechy` tinytext NOT NULL,
  `zdjecia` tinytext NOT NULL,
  `prototyp` tinyint(1) NOT NULL,
  `logowanie` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Zrzut danych tabeli `produkty_no_old`
--

INSERT INTO `produkty_no_old` (`id`, `nazwa`, `opis`, `kategoria`, `branza`, `cechy`, `zdjecia`, `prototyp`, `logowanie`) VALUES
(1, 'Etui na dokumenty podróży', 'Etui na dokumenty podróży - Prototyp Achilles Polska', '2', '16', '0', ',984,985,', 0, 0),
(2, 'Teczka na dokumenty samochodu', 'Teczka na dokumenty samochodu - Prototyp Achilles Polska', '2', '10', '1', ',982,983,', 0, 0),
(3, 'Teczka Peugeot Bank', 'Teczka Peugeot Bank. Dodatkowe elementy: kieszeń sztancowana na dokumenty, gumka zamykająca. ', '2', '10', '1,5', ',853,854,855,', 0, 0),
(4, 'Teczka Matopat', 'Teczka wielobigowa. Dodatkowe elementy - pudełka z polipropylenu stanowiące boki teczki, mechanizm. ', '2', '9', '3,4', ',849,850,851,', 0, 0),
(5, 'Teczka Domowe Klimaty', 'Teczka wielobigowa.', '2', '1', '1,6', ',847,848,', 0, 0),
(6, 'Teczka Citroen Bank', 'Teczka Citroen Bank. Dodatkowe elementy: kieszeń sztancowana na dokumenty, gumka zamykająca.', '2', '5', '1,5', ',844,845,846,', 0, 0),
(7, 'Teczka CDS GROUP', 'Teczka CDS GROUP.', '2', '3', '1,5', ',842,843,', 0, 0),
(8, 'Teczka BANK BGŻ', 'Teczka BANK BGŻ. Dodatkowe elementy: zamknięcie na magnes, mechanizm ringowy, wireclip, uchwyt na długopis, notes. ', '2', '5', '1,7', ',838,839,', 0, 0),
(9, 'Segregator E-szkoła', 'Segregator E-szkoła. Mechanizm R25/04. Dodatkowe wyposażenie: przekładki katalogowe.', '1', '2', '1,8', ',217,362,363,364,', 0, 0),
(10, 'Segregator Florum/D65', 'Segregator Florum/D65. Mechanizm D65/02. ', '1', '3', '1,5', ',304,307,308,', 0, 0),
(11, 'Segregator Allianz/D52', 'Segregator Allianz/D52. Mechanizm D52/02. ', '1', '17', '1,5', ',310,311,312,', 0, 0),
(12, 'Segregator Le Charme', 'Segregator Le Charme.', '1', '11', '9', ',330,331,333,334,335,336,', 0, 0),
(13, 'Katalog Achilles', 'Segregator z etui oraz kompletem kart katalogowych. Mechanizm D20/03. Dodatkowe elementy: lakierowany mechanizm.', '1', '1', '10', ',344,345,347,348,349,350,351,', 0, 0),
(14, 'Segregator Bims Plus/D45', 'Segregator Bims Plus/D45. Mechanizm D45/02. ', '1', '1', '1,5', ',413,414,415,', 0, 0),
(15, 'Segregator Sanplast D40/04', 'Segregator Sanplast D40/04. Mechanizm D40/04. Dodatkowe wyposażenie: kółko na grzbiecie. ', '1', '1', '1,6', ',417,418,419,', 0, 0),
(16, 'Segregator P&G/D35', 'Segregator P&G/D35. Mechanizm D35/02. Dodatkowe wyposażenie: przekładki katalogowe, kompresor, kieszonka na dokumenty, kieszonka na CD.', '1', '15', '1,10', ',421,422,423,424,426,', 0, 0),
(17, 'Clipboard Achilles', 'Clipboard Achilles. ', '3', '1', '1,10', ',106,', 0, 0),
(18, 'Clipboard Interservis', 'Clipboard Interservis, zamykany. Mechanizm: WCL 100, uchwyt na długopis. Grzbiet: wielobig. ', '3', '12', '1,11', ',316,317,481,', 0, 0),
(19, 'Clipboard zamykany Achilles', 'Clipboard zamykany Achilles. Mechanizm WCL 100, uchwyt na długopis. Grzbiet: wielobig.', '3', '1', '1,12', ',470,', 0, 0),
(20, 'Clipboard WOŚP', 'Clipboard WOŚP.', '3', '13', '1,11', ',800,801,', 0, 0),
(21, 'Clipboard PROFI', 'Clipboard PROFI. Dodatkowe elementy - mechanizm lakierowany.', '3', '7', '1,13', ',806,807,808,', 0, 0),
(22, 'Clipboard SKOK', 'Clipboard SKOK. Dodatkowe elementy - mechanizm, bloczki ze stikerami.', '3', '5', '1,11', ',809,810,', 0, 0),
(23, 'Pudełko Achilles', 'Pudełko Achilles na dokumenty, płyty CD lub inne kolekcje.', '4', '1', '5', ',244,', 0, 0),
(24, 'Komplet etui SAPA', 'Komplet 2 etui na materiały reklamowe.', '4', '1', '14', ',720,798,799,', 0, 0),
(25, 'Etui "Zamachy"', 'Etui na DVD.', '4', '8', '15', ',534,', 0, 0),
(26, 'Etui Columbo', 'Etui na okładkę do płyt CD/DVD.', '4', '8', '15', ',526,527,', 0, 0),
(27, 'Prezenter LMI', 'Prezenter LMI. Uszlachetnienie - kalander gruby oklejka, kalander drobny wklejka.', '5', '1', '1,11', ',811,812,813,', 0, 0),
(28, 'Prezenter - etui na soczewki JZO', 'Prezenter dostosowany formatem do potrzeb klienta. Dodatkowe elementy - zapięcie na magnes, wkładki z pianki na soczewki, kieszeń wklejana. ', '5', '9', '8', ',506,507,', 0, 0),
(29, 'Prezenter Gala', 'Prezenter dostosowany formatem do potrzeb klienta. Uszlachetnienie - kalander gruby. ', '5', '7', '11', ',490,491,494,495,', 0, 0),
(30, 'Prezenter Master Card', 'Prezenter dostosowany formatem do potrzeb klienta. Prezenter wyposażony w tablicę do pisania, marker oraz gąbkę. ', '5', '5', '5', ',155,319,320,321,339,', 0, 0),
(31, 'Etui na soczewki okularowe', 'Etui na soczewki okularowe - Prototyp Achilles Polska', '6', '9', '0', ',986,987,', 0, 0),
(32, 'PAGED wzornik tkanin', 'Wzornik tkanin. Dodatkowe elementy: dwa mechanizmy do umieszczenia próbek.', '6', '7', '16', ',820,821,', 0, 0),
(33, 'GINTARO wzornik tkanin', 'Wzornik. Dodatkowe elementy: wkładka z PCV spienionego - wieszak.', '6', '7', '17', ',770,771,772,', 0, 0),
(34, 'Wzornik GLASS MIX', 'Wzornik, format specjalny. Druk 4/4, błyszczący ,kalander. Dodatkowe elementy: zakładki zabezpieczające', '6', '1', '18', ',694,695,701,', 0, 0),
(35, 'Okładka na zwolnienia L4 Advantan', 'Okładka na zwolnienia lekarskie L4. Zastosowano gumkę zamykającą oraz przekładkę zapobiegającą samokopiowaniu. Mechanizm WCL 100. ', '7', '4', '10', ',792,795,', 0, 0),
(36, 'Okładka na zwolnienia L4 Pharma Nord', 'Okładka na zwolnienia lekarskie L4. Dodatkowe elementy: gumka zamykająca oraz przekładka, mechanizm WCL100.', '7', '4', '10', ',550,551,552,', 0, 0),
(37, 'Receptariusz Spuriva', 'Okładka na recepty (receptariusz). Zastosowano gumkę zamykającą. Mechanizm WL 100.', '7', '9', '11', ',96,358,359,', 0, 0),
(38, 'Okładka na zwolnienia L4 Aspirin', 'Okładka na zwolnienia lekarskie L4. Zastosowano gumkę zamykającą oraz przekładkę zapobiegającą samokopiowaniu. Mechanizm WCL 100.', '7', '4', '10', ',88,355,356,357,', 0, 0),
(39, 'Pudełko na wino pionowe z klapką', 'Pudełko na wino pionowe z klapką - Prototyp Achilles Polska.', '8', '1', '0', ',976,977,978,979,', 1, 0),
(40, 'Pudełko na wino z przykrywką z okienkiem', 'Pudełko na wino pionowe z przykrywką z okienkiem - Prototyp Achilles Polska.', '8', '1', '0', ',980,', 1, 0),
(41, 'Pudełko na wino - tuba', 'Pudełko na wino pionowe w formie tuby - Prototyp Achilles Polska.', '8', '1', '0', ',981,', 1, 0),
(42, 'Teczka DRE', 'Teczka - wzornik szkła. Dodatkowe elementy - wzmocnienie ścianki tylnej. ', '2', '1', '8', ',827,828,829,', 0, 0),
(43, 'Segregator Philips/D30', 'Segregator Philips/D30. Mechanizm D30/02. Dodatkowe wyposażenie: kompresor. ', '1', '3', '1,11', ',439,440,441,', 0, 0),
(44, 'Segregator Gaspol/D25', 'Segregator Gaspol/D25. Mechanizm D25/02. ', '1', '1', '1,15', ',443,445,447,', 0, 0),
(45, 'Segregator Rintal/D20', 'Segregator Rintal/D20. Mechanizm D20/02.', '1', '1', '1,5', ',449,450,451,', 0, 0),
(46, 'Segregator Porta/D16', 'Segregator Porta/D16Segregator, format A4. Druk 4/0, folia matowa. Mechanizm D16/02. ', '1', '1', '1,8', ',452,453,454,', 0, 0),
(47, 'Segregator Warta/D16', 'Segregator Warta/D16 format A4. Druk 4/0, folia matowa. Mechanizm D16/02. ', '1', '17', '1,8', ',455,456,457,', 0, 0),
(48, 'Segregator Achilles', 'Segregator z mechanizmem dźwigniowym. Mechanizm F75. Zastosowano kółko na grzbiecie i zapięcie RADO.', '1', '1', '19', ',500,501,', 0, 0),
(49, 'Segregator Muraspec', 'Segregator Muraspec. Mechanizm D65/02. Oklejany tkaniną. Dodatkowy element - sitodruk.', '1', '1', '0', ',521,522,', 0, 0),
(50, 'Segregator Famos', 'Segregator Famos. Dodatkowe elementy - lakier UV, grzbiet wielobigowy .', '1', '7', '1,10', ',816,817,', 0, 0),
(51, 'Segregator Warta Smok', 'Segregator Warta Smok.', '1', '17', '15', ',822,823,', 0, 0),
(52, 'Segregator BRW', 'Segregator "poziomy" z mechanizmem. Specjalny format tektury.', '1', '7', '8', ',814,815,', 0, 0),
(53, 'Segregator Paged', 'Segregator Paged. Dodatkowe elementy - 2 kieszenie na CD.', '1', '7', '1,8', ',818,819,', 0, 0),
(54, 'Teczka Archon', 'Teczka Archon', '2', '1', '1,8', ',832,834,837,', 0, 0),
(55, 'Teczka LOTOS', 'Teczka LOTOS. Dodatkowe elementy: plastikowe boczki.', '2', '14', '1,20', ',830,831,', 0, 0),
(56, 'Teczka Converse', 'Teczka Converse. Dodatkowe elementy: plastikowe boki, gumka.', '2', '11', '1,10', ',824,825,', 0, 0),
(57, 'Okładka Gdańsk 2000', 'Okładka Gdańsk 2000. Dodatkowy element - zapięcie na magnes.', '2', '13', '21', ',802,803,805,', 0, 0),
(58, 'Teczka testowy', 'Teczka testowy. Dodatkowe elementy: plastikowe boki, gumka.', '2', '1', '1,10', ',784,786,787,788,789,790,791,', 0, 0),
(59, 'Teczka Amgen', 'Teczka Amgen. Dodatkowe elementy: kieszenie sztancowane na dokumenty.', '2', '9', '1,8', ',565,566,', 0, 0),
(60, 'Teczka Polskie Radio', 'Teczka Polskie Radio. Dodatkowe elementy: magnesy zamykające.', '2', '8', '1,16', ',594,595,597,', 0, 0),
(61, 'Teczka Paged', 'Teczka z rączką. Dodatkowe elementy: lakier punktowy UV.', '2', '7', '8', ',572,573,577,', 0, 0),
(62, 'Teczka harmonijkowa Bank Pocztowy', 'Teczka harmonijkowa Bank Pocztowy. Dodatkowe elementy: przekładki z registrami.', '2', '5', '1,8', ',561,562,', 0, 0),
(63, 'Teczka LOTOS', 'Teczka LOTOS. Dodatkowe elementy: mechanizm dźwigniowy.', '2', '14', '1,8', ',540,542,544,', 0, 0),
(64, 'Teczka Tikkurila', 'Teczka Tikkurila. Dodatkowe elementy: przegroda tekturowa, wkładka z pianki PE.', '2', '1', '1,22', ',515,516,', 0, 0),
(65, 'Clipboard', 'Clipboard', '3', '2', '1,10', ',781,782,', 0, 0),
(66, 'Pudełko Porta', 'Pudełko na dokumenty lub próbki. Zastosowano plastikowe narożniki.', '4', '1', '8', ',99,352,', 0, 0),
(67, 'Pudełko Achilles', 'Pudełko na płyty CD, karty lub inne kolekcje.', '4', '1', '5', ',103,353,354,', 0, 0),
(68, 'Etui Święty', 'Etui na okładkę do płyt CD/DVD.', '4', '8', '15', ',137,337,338,', 0, 0),
(69, 'Etui Le Charme', 'Etui na segregator.', '4', '11', '19', ',135,324,325,326,327,328,', 0, 0),
(70, 'Etui Achilles', 'Etui na segregator.', '4', '1', '8', ',250,340,341,342,', 0, 0),
(71, 'Wzornik Ceramika Gres', 'Wzornik, format specjalny. Dodatkowe elementy: przekładka zabezpieczająca. ', '6', '1', '23', ',172,410,411,412,', 0, 0),
(72, 'Wzornik', 'Wzornik. Dodatkowe elementy: wkładka piankowa do umieszczenia próbek.', '6', '1', '17', ',174,', 0, 0),
(73, 'Wzornik Kabe', 'Wzornik tynków.', '6', '1', '19', ',164,408,409,', 0, 0),
(74, 'Wizytownik ', 'Wizytownik Achilles. Mechanizm R20/04. Dodatkowe elementy: kieszonki na wizytówki, skorowidz. ', '9', '1', '24', ',460,508,', 0, 0),
(75, 'Wizytownik Archon', 'Wizytownik Archon. Mechanizm: R20/04. Dodatkowe elementy: kieszonki na wizytówki, skorowidz. ', '9', '1', '16', ',129,406,407,', 0, 0),
(76, 'Teczka', 'Teczka z polipropylenu', '10', '1', '1', ',produkty_PP1,produkty_PP1,', 0, 0),
(77, 'Stojak na ulotki Archon', 'Stojak na ulotki Archon', '11', '1', '1', ',ulotkownik1,ulotkownik1,', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `produkty_pl`
--

CREATE TABLE IF NOT EXISTS `produkty_pl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `kategoria` tinytext NOT NULL,
  `branza` tinytext NOT NULL,
  `cechy` tinytext NOT NULL,
  `zdjecia` tinytext NOT NULL,
  `prototyp` tinyint(1) NOT NULL,
  `logowanie` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Zrzut danych tabeli `produkty_pl`
--

INSERT INTO `produkty_pl` (`id`, `nazwa`, `opis`, `kategoria`, `branza`, `cechy`, `zdjecia`, `prototyp`, `logowanie`) VALUES
(1, 'Etui na dokumenty podróży', 'Etui na dokumenty podróży', '2', '16', '0', ',984,985,', 0, 1),
(2, 'Teczka na dokumenty samochodu', 'Teczka na dokumenty samochodu - Prototyp Achilles Polska', '2', '10', '1', ',982,983,', 0, 0),
(3, 'Teczka Peugeot Bank', 'Teczka Peugeot Bank. Dodatkowe elementy: kieszeń sztancowana na dokumenty, gumka zamykająca. ', '2', '10', '1,5', ',853,854,855,', 0, 0),
(4, 'Teczka Matopat', 'Teczka wielobigowa. Dodatkowe elementy - pudełka z polipropylenu stanowiące boki teczki, mechanizm. ', '2', '9', '3,4', ',849,850,851,', 0, 0),
(5, 'Teczka Domowe Klimaty', 'Teczka wielobigowa.', '2', '1', '1,6', ',847,848,', 0, 0),
(6, 'Teczka Citroen Bank', 'Teczka Citroen Bank. Dodatkowe elementy: kieszeń sztancowana na dokumenty, gumka zamykająca.', '2', '5', '1,5', ',844,845,846,', 0, 0),
(7, 'Teczka CDS GROUP', 'Teczka CDS GROUP.', '2', '3', '1,5', ',842,843,', 0, 0),
(8, 'Teczka BANK BGŻ', 'Teczka BANK BGŻ. Dodatkowe elementy: zamknięcie na magnes, mechanizm ringowy, wireclip, uchwyt na długopis, notes. ', '2', '5', '1,7', ',838,839,', 0, 0),
(9, 'Segregator E-szkoła', 'Segregator E-szkoła. Mechanizm R25/04. Dodatkowe wyposażenie: przekładki katalogowe.', '1', '2', '1,8', ',217,362,363,364,', 0, 0),
(10, 'Segregator Florum/D65', 'Segregator Florum/D65. Mechanizm D65/02. ', '1', '3', '1,5', ',304,307,308,', 0, 0),
(11, 'Segregator Allianz/D52', 'Segregator Allianz/D52. Mechanizm D52/02. ', '1', '17', '1,5', ',310,311,312,', 0, 0),
(12, 'Segregator Le Charme', 'Segregator Le Charme.', '1', '11', '9', ',330,331,333,334,335,336,', 0, 0),
(13, 'Katalog Achilles', 'Segregator z etui oraz kompletem kart katalogowych. Mechanizm D20/03. Dodatkowe elementy: lakierowany mechanizm.', '1', '1', '10', ',344,345,347,348,349,350,351,', 0, 0),
(14, 'Segregator Bims Plus/D45', 'Segregator Bims Plus/D45. Mechanizm D45/02. ', '1', '1', '1,5', ',413,414,415,', 0, 0),
(15, 'Segregator Sanplast D40/04', 'Segregator Sanplast D40/04. Mechanizm D40/04. Dodatkowe wyposażenie: kółko na grzbiecie. ', '1', '1', '1,6', ',417,418,419,', 0, 0),
(16, 'Segregator P&G/D35', 'Segregator P&G/D35. Mechanizm D35/02. Dodatkowe wyposażenie: przekładki katalogowe, kompresor, kieszonka na dokumenty, kieszonka na CD.', '1', '15', '1,10', ',421,422,423,424,426,', 0, 0),
(17, 'Clipboard Achilles', 'Clipboard Achilles. ', '3', '1', '1,10', ',106,', 0, 0),
(18, 'Clipboard Interservis', 'Clipboard Interservis, zamykany. Mechanizm: WCL 100, uchwyt na długopis. Grzbiet: wielobig. ', '3', '12', '1,11', ',316,317,481,', 0, 0),
(19, 'Clipboard zamykany Achilles', 'Clipboard zamykany Achilles. Mechanizm WCL 100, uchwyt na długopis. Grzbiet: wielobig.', '3', '1', '1,12', ',470,', 0, 0),
(20, 'Clipboard WOŚP', 'Clipboard WOŚP.', '3', '13', '1,11', ',800,801,', 0, 0),
(21, 'Clipboard PROFI', 'Clipboard PROFI. Dodatkowe elementy - mechanizm lakierowany.', '3', '7', '1,13', ',806,807,808,', 0, 0),
(22, 'Clipboard SKOK', 'Clipboard SKOK. Dodatkowe elementy - mechanizm, bloczki ze stikerami.', '3', '5', '1,11', ',809,810,', 0, 0),
(23, 'Pudełko Achilles', 'Pudełko Achilles na dokumenty, płyty CD lub inne kolekcje.', '4', '1', '5', ',244,', 0, 0),
(24, 'Komplet etui SAPA', 'Komplet 2 etui na materiały reklamowe.', '4', '1', '14', ',720,798,799,', 0, 0),
(25, 'Etui "Zamachy"', 'Etui na DVD.', '4', '8', '15', ',534,', 0, 0),
(26, 'Etui Columbo', 'Etui na okładkę do płyt CD/DVD.', '4', '8', '15', ',526,527,', 0, 0),
(27, 'Prezenter LMI', 'Prezenter LMI. Uszlachetnienie - kalander gruby oklejka, kalander drobny wklejka.', '5', '1', '1,11', ',811,812,813,', 0, 0),
(28, 'Prezenter - etui na soczewki JZO', 'Prezenter dostosowany formatem do potrzeb klienta. Dodatkowe elementy - zapięcie na magnes, wkładki z pianki na soczewki, kieszeń wklejana. ', '5', '9', '8', ',506,507,', 0, 0),
(29, 'Prezenter Gala', 'Prezenter dostosowany formatem do potrzeb klienta. Uszlachetnienie - kalander gruby. ', '5', '7', '11', ',490,491,494,495,', 0, 0),
(30, 'Prezenter Master Card', 'Prezenter dostosowany formatem do potrzeb klienta. Prezenter wyposażony w tablicę do pisania, marker oraz gąbkę. ', '5', '5', '5', ',155,319,320,321,339,', 0, 0),
(31, 'Etui na soczewki okularowe', 'Etui na soczewki okularowe - Prototyp Achilles Polska', '6', '9', '0', ',986,987,', 0, 0),
(32, 'PAGED wzornik tkanin', 'Wzornik tkanin. Dodatkowe elementy: dwa mechanizmy do umieszczenia próbek.', '6', '7', '16', ',820,821,', 0, 0),
(33, 'GINTARO wzornik tkanin', 'Wzornik. Dodatkowe elementy: wkładka z PCV spienionego - wieszak.', '6', '7', '17', ',770,771,772,', 0, 0),
(34, 'Wzornik GLASS MIX', 'Wzornik, format specjalny. Druk 4/4, błyszczący ,kalander. Dodatkowe elementy: zakładki zabezpieczające', '6', '1', '18', ',694,695,701,', 0, 0),
(35, 'Okładka na zwolnienia L4 Advantan', 'Okładka na zwolnienia lekarskie L4. Zastosowano gumkę zamykającą oraz przekładkę zapobiegającą samokopiowaniu. Mechanizm WCL 100. ', '7', '4', '10', ',792,795,', 0, 0),
(36, 'Okładka na zwolnienia L4 Pharma Nord', 'Okładka na zwolnienia lekarskie L4. Dodatkowe elementy: gumka zamykająca oraz przekładka, mechanizm WCL100.', '7', '4', '10', ',550,551,552,', 0, 0),
(37, 'Receptariusz Spuriva', 'Okładka na recepty (receptariusz). Zastosowano gumkę zamykającą. Mechanizm WL 100.', '7', '9', '11', ',96,358,359,', 0, 0),
(38, 'Okładka na zwolnienia L4 Aspirin', 'Okładka na zwolnienia lekarskie L4. Zastosowano gumkę zamykającą oraz przekładkę zapobiegającą samokopiowaniu. Mechanizm WCL 100.', '7', '4', '10', ',88,355,356,357,', 0, 0),
(39, 'Pudełko na wino pionowe z klapką', 'Pudełko na wino pionowe z klapką - Prototyp Achilles Polska.', '8', '1', '0', ',976,977,978,979,', 1, 0),
(40, 'Pudełko na wino z przykrywką z okienkiem', 'Pudełko na wino pionowe z przykrywką z okienkiem - Prototyp Achilles Polska.', '8', '1', '0', ',980,', 1, 0),
(41, 'Pudełko na wino - tuba', 'Pudełko na wino pionowe w formie tuby - Prototyp Achilles Polska.', '8', '1', '0', ',981,', 1, 0),
(42, 'Teczka DRE', 'Teczka - wzornik szkła. Dodatkowe elementy - wzmocnienie ścianki tylnej. ', '2', '1', '8', ',827,828,829,', 0, 0),
(43, 'Segregator Philips/D30', 'Segregator Philips/D30. Mechanizm D30/02. Dodatkowe wyposażenie: kompresor. ', '1', '3', '1,11', ',439,440,441,', 0, 0),
(44, 'Segregator Gaspol/D25', 'Segregator Gaspol/D25. Mechanizm D25/02. ', '1', '1', '1,15', ',443,445,447,', 0, 0),
(45, 'Segregator Rintal/D20', 'Segregator Rintal/D20. Mechanizm D20/02.', '1', '1', '1,5', ',449,450,451,', 0, 0),
(46, 'Segregator Porta/D16', 'Segregator Porta/D16Segregator, format A4. Druk 4/0, folia matowa. Mechanizm D16/02. ', '1', '1', '1,8', ',452,453,454,', 0, 0),
(47, 'Segregator Warta/D16', 'Segregator Warta/D16 format A4. Druk 4/0, folia matowa. Mechanizm D16/02. ', '1', '17', '1,8', ',455,456,457,', 0, 0),
(48, 'Segregator Achilles', 'Segregator z mechanizmem dźwigniowym. Mechanizm F75. Zastosowano kółko na grzbiecie i zapięcie RADO.', '1', '1', '19', ',500,501,', 0, 0),
(49, 'Segregator Muraspec', 'Segregator Muraspec. Mechanizm D65/02. Oklejany tkaniną. Dodatkowy element - sitodruk.', '1', '1', '0', ',521,522,', 0, 0),
(50, 'Segregator Famos', 'Segregator Famos. Dodatkowe elementy - lakier UV, grzbiet wielobigowy .', '1', '7', '1,10', ',816,817,', 0, 0),
(51, 'Segregator Warta Smok', 'Segregator Warta Smok.', '1', '17', '15', ',822,823,', 0, 0),
(52, 'Segregator BRW', 'Segregator "poziomy" z mechanizmem. Specjalny format tektury.', '1', '7', '8', ',814,815,', 0, 0),
(53, 'Segregator Paged', 'Segregator Paged. Dodatkowe elementy - 2 kieszenie na CD.', '1', '7', '1,8', ',818,819,', 0, 0),
(54, 'Teczka Archon', 'Teczka Archon', '2', '1', '1,8', ',832,834,837,', 0, 0),
(55, 'Teczka LOTOS', 'Teczka LOTOS. Dodatkowe elementy: plastikowe boczki.', '2', '14', '1,20', ',830,831,', 0, 0),
(56, 'Teczka Converse', 'Teczka Converse. Dodatkowe elementy: plastikowe boki, gumka.', '2', '11', '1,10', ',824,825,', 0, 0),
(57, 'Okładka Gdańsk 2000', 'Okładka Gdańsk 2000. Dodatkowy element - zapięcie na magnes.', '2', '13', '21', ',802,803,805,', 0, 0),
(58, 'Teczka testowy', 'Teczka testowy. Dodatkowe elementy: plastikowe boki, gumka.', '2', '1', '1,10', ',784,786,787,788,789,790,791,', 0, 0),
(59, 'Teczka Amgen', 'Teczka Amgen. Dodatkowe elementy: kieszenie sztancowane na dokumenty.', '2', '9', '1,8', ',565,566,', 0, 0),
(60, 'Teczka Polskie Radio', 'Teczka Polskie Radio. Dodatkowe elementy: magnesy zamykające.', '2', '8', '1,16', ',594,595,597,', 0, 0),
(61, 'Teczka Paged', 'Teczka z rączką. Dodatkowe elementy: lakier punktowy UV.', '2', '7', '8', ',572,573,577,', 0, 0),
(62, 'Teczka harmonijkowa Bank Pocztowy', 'Teczka harmonijkowa Bank Pocztowy. Dodatkowe elementy: przekładki z registrami.', '2', '5', '1,8', ',561,562,', 0, 0),
(63, 'Teczka LOTOS', 'Teczka LOTOS. Dodatkowe elementy: mechanizm dźwigniowy.', '2', '14', '1,8', ',540,542,544,', 0, 0),
(64, 'Teczka Tikkurila', 'Teczka Tikkurila. Dodatkowe elementy: przegroda tekturowa, wkładka z pianki PE.', '2', '1', '1,22', ',515,516,', 0, 0),
(65, 'Clipboard', 'Clipboard', '3', '2', '1,10', ',781,782,', 0, 0),
(66, 'Pudełko Porta', 'Pudełko na dokumenty lub próbki. Zastosowano plastikowe narożniki.', '4', '1', '8', ',99,352,', 0, 0),
(67, 'Pudełko Achilles', 'Pudełko na płyty CD, karty lub inne kolekcje.', '4', '1', '5', ',103,353,354,', 0, 0),
(68, 'Etui Święty', 'Etui na okładkę do płyt CD/DVD.', '4', '8', '15', ',137,337,338,', 0, 0),
(69, 'Etui Le Charme', 'Etui na segregator.', '4', '11', '19', ',135,324,325,326,327,328,', 0, 0),
(70, 'Etui Achilles', 'Etui na segregator.', '4', '1', '8', ',250,340,341,342,', 0, 0),
(71, 'Wzornik Ceramika Gres', 'Wzornik, format specjalny. Dodatkowe elementy: przekładka zabezpieczająca. ', '6', '1', '23', ',172,410,411,412,', 0, 0),
(72, 'Wzornik', 'Wzornik. Dodatkowe elementy: wkładka piankowa do umieszczenia próbek.', '6', '1', '17', ',174,', 0, 0),
(73, 'Wzornik Kabe', 'Wzornik tynków.', '6', '1', '19', ',164,408,409,', 0, 0),
(74, 'Wizytownik ', 'Wizytownik Achilles. Mechanizm R20/04. Dodatkowe elementy: kieszonki na wizytówki, skorowidz. ', '9', '1', '24', ',460,508,', 0, 0),
(75, 'Wizytownik Archon', 'Wizytownik Archon. Mechanizm: R20/04. Dodatkowe elementy: kieszonki na wizytówki, skorowidz. ', '9', '1', '16', ',129,406,407,', 0, 0),
(76, 'Teczka', 'Teczka z polipropylenu', '10', '1', '1', ',produkty_PP1,produkty_PP1,', 0, 0),
(77, 'Stojak na ulotki Archon', 'Stojak na ulotki Archon', '11', '1', '1', ',ulotkownik1,', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `produkty_se`
--

CREATE TABLE IF NOT EXISTS `produkty_se` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `kategoria` tinytext NOT NULL,
  `branza` tinytext NOT NULL,
  `cechy` tinytext NOT NULL,
  `zdjecia` tinytext NOT NULL,
  `prototyp` tinyint(1) NOT NULL,
  `logowanie` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

--
-- Zrzut danych tabeli `produkty_se`
--

INSERT INTO `produkty_se` (`id`, `nazwa`, `opis`, `kategoria`, `branza`, `cechy`, `zdjecia`, `prototyp`, `logowanie`) VALUES
(1, 'Etui na dokumenty podróży', 'Etui na dokumenty podróży - Prototyp Achilles Polska', '2', '16', '0', ',984,985,', 0, 0),
(2, 'Teczka na dokumenty samochodu', 'Teczka na dokumenty samochodu - Prototyp Achilles Polska', '2', '10', '1', ',982,983,', 0, 0),
(3, 'Peugeot Bank folder', 'Peugeot Bank folder, A4 format.Print 4/0, glossy finish.Accessories:die-cut pocket for documents, rubber band closure.', '2', '10', '1,5', ',853,854,855,', 0, 0),
(4, 'Matopat folder ', 'folder, multibend 480x300x90 mmformatPrint 3/0 special matt finishAccessories -  polypropylene sides, rings .', '2', '9', '3,4', ',849,850,851,', 0, 0),
(5, 'Domowe Klimaty folder', 'folder, multibend A4 format.Print 2/0 matt finish', '2', '1', '1,6', ',847,848,', 0, 0),
(6, 'Citroen Bank folder', 'Citroen Bank folder, A4 format.Print 4/0, glossy finish.Accessories:die-cut pocket for documents, rubber band closure.', '2', '5', '1,5', ',844,845,846,', 0, 0),
(7, 'CDS GROUP folder', 'folder, A4 format.Print 4/0 glossy finish', '2', '3', '1,5', ',842,843,', 0, 0),
(8, 'BGZ Bank folder', 'folder, A4 format.Print 4/4, matt finish, UV varnish.Accessories: ring, magnet closure,wireclip, pen holder, notebook .', '2', '5', '1,7', ',838,839,', 0, 0),
(9, 'E-szkoła ring binder', 'ring binder, A4 format.Print 4/0, matt finish.Ring R25/04.Accessories: index tabs.', '1', '2', '1,8', ',217,362,363,364,', 0, 0),
(10, 'Florum ring binder / D65', 'ring binder, A4 format.Print 4/0, glossy finish.Ring D65/02.', '1', '3', '1,5', ',304,307,308,', 0, 0),
(11, 'Allianz ring binder  / D52', 'ring binder, A4 format.Print 4/0, glossy finish.Ring D52/02.', '1', '17', '1,5', ',310,311,312,', 0, 0),
(12, 'Le Charme ring binder', 'ring binder, special format.Print 4/4, patterned glossy finish.', '1', '11', '9', ',330,331,333,334,335,336,', 0, 0),
(13, 'Achilles catalogue', 'ring binder with a slipcase and index tabs.Print 4/4, matt finish.Ring D20/03Accessories: powder coated Ring.', '1', '1', '10', ',344,345,347,348,349,350,351,', 0, 0),
(14, 'Bims Plus ring binder / D45', 'ring binder, A4 format.Print 4/0, glossy finish.Ring  D45/02.', '1', '1', '1,5', ',413,414,415,', 0, 0),
(15, 'Sanplast ring binder / D40/04', 'ring binder, A4 format.Print 2/0, matt finish.Ring D40/04.Accessories: metal hole.', '1', '1', '1,6', ',417,418,419,', 0, 0),
(16, ' P&amp;G ring binder / D35', 'ring binder, A4 format.Print 4/4, matt finish.Ring D35/02.Accessories: index tabs, wire compressor,CD and documents pockets.', '1', '15', '1,10', ',421,422,423,424,426,', 0, 0),
(17, 'Achilles clipboard', 'clipboard, format  A4. Print 4/4, matt finish.', '3', '1', '1,10', ',106,', 0, 0),
(18, 'Interservis clipboard', 'folded clipboard, A4 format.Print 4/4, glossy finish.Ring: WCL 100, pen holderBack: multibend.', '3', '12', '1,11', ',316,317,481,', 0, 0),
(19, 'Achilles clipboard', 'clipboard with a fold, A4 format. Print 4/4, patterned glossy finish, UV varnish.Ring WCL 100, pen holder.Multibend ridge.', '3', '1', '1,12', ',470,', 0, 0),
(20, 'WOSP clipboard', 'Clipboard, format  A4. Print 4/4, glossy finish', '3', '13', '1,11', ',800,801,', 0, 0),
(21, 'PROFI clipboard  ', 'Clipboard, A4 format. Print 4/4, matt finish, glossy UV varnish.Accessories - powder coated rings.', '3', '7', '1,13', ',806,807,808,', 0, 0),
(22, 'SKOK clipboard', 'clipboard, format  A4. Print 4/4, glossy finish.Accessories - rings, sticky notes', '3', '5', '1,11', ',809,810,', 0, 0),
(23, 'box Achilles', 'box for documents, CDs or other collections.Print 4/0, glossy finish.', '4', '1', '5', ',244,', 0, 0),
(24, 'SAPA set of cases', 'set of 2 cases for promotional materials.Print 2/0 - silver, black, special matt finish,', '4', '1', '14', ',720,798,799,', 0, 0),
(25, '&quot;Zamachy&quot; slipcase', 'slipcase for DVD Print 4/0 , matt finish, UV varnish.', '4', '8', '15', ',534,', 0, 0),
(26, 'Columbo slipcase', 'slipcase for CD/DVD.Print 4/0, matt finish, UV varnish', '4', '8', '15', ',526,527,', 0, 0),
(27, 'LMI easel binder', 'easel binder A4 Print 4/4, glossy finish, embossing', '5', '1', '1,11', ',811,812,813,', 0, 0),
(28, 'Prezenter - etui na soczewki JZO', 'Prezenter dostosowany formatem do potrzeb klienta. Dodatkowe elementy - zapięcie na magnes, wkładki z pianki na soczewki, kieszeń wklejana. ', '5', '9', '8', ',506,507,', 0, 0),
(29, 'Gala easel binder', 'easel binder, custom format.Print 4/4, glossy finish, paper finish - thick embossing.', '5', '7', '11', ',490,491,494,495,', 0, 0),
(30, 'Master Card easel binder', 'custom-made easel binder.Print 4/0, glossy finish.Easel binder with whiteboard, marker and sponge.', '5', '5', '5', ',155,319,320,321,339,', 0, 0),
(31, 'Etui na soczewki okularowe', 'Etui na soczewki okularowe - Prototyp Achilles Polska', '6', '9', '0', ',986,987,', 0, 0),
(32, 'PAGED sample folder for fabrics', 'sample folder for fabricsPrint 4/0, laminat matowy.Accessories: two rings for samples.', '6', '7', '16', ',820,821,', 0, 0),
(33, 'GINTARO sample folder for fabrics', 'sample folderPrint 4/0, glossy laminate.Accessories:PCV hanger', '6', '7', '17', ',770,771,772,', 0, 0),
(34, 'GLASS MIX sample folder', 'sample folder, special format.Print 4/4, glossy ,embossing.Accessories: protective folds.', '6', '1', '18', ',694,695,701,', 0, 0),
(35, 'Advantan folder for sick leave forms', 'folder for sick leave forms.Print 4/4, matt finish.Elastic band closure and separator against self-copying.Rings WCL 100.', '2', '', '', ',792,795,', 0, 0),
(36, 'Pharma Nord folder for sick leave forms', 'Folder for sick leave forms.Print 4/4, matt finish.Accessories : rubber band closure, separator, WCL100 ring', '2', '', '', ',550,551,552,', 0, 0),
(37, 'Spuriva prescription folder', 'prescription folderPrint 4/4, glossy finish.With elastic band closure.Ring WL 100.', '7', '9', '11', ',96,358,359,', 0, 0),
(38, 'Aspirin folder for sick leave forms', 'folder for sick leave forms.Print 4/4, matt finish.With elastic band closure and separator against self-copying.Ring WCL 100.', '7', '4', '10', ',88,355,356,357,', 0, 0),
(39, 'Wine box with a flap', 'Wine box with a flap - Achilles Polska Prototype', '8', '1', '0', ',976,977,978,979,', 1, 0),
(40, 'Stand-up wine box with window lid', 'Stand-up wine box with window lid - Achilles Polska Prototype', '8', '1', '0', ',980,', 1, 0),
(41, 'Tube-shaped wine box', 'Tube-shaped stand-up box for wine or spirits - Achilles Polska Prototype', '8', '1', '0', ',981,', 1, 0),
(42, 'DRE folder', 'sample folder for glassPrint 4/0 matt finish Accessories -  strengthened back.', '2', '1', '8', ',827,828,829,', 0, 0),
(43, 'Philips ring binder / D30', 'ring binder, A4 format.Print 4/4, glossy finish.Ring D30/02.Accessories: wire compressor.', '1', '3', '1,11', ',439,440,441,', 0, 0),
(44, 'Gaspol ring binder / D25', 'ring binder, A4 format.Print 4/0, matt finish, UV varnish.Ring D25/02.', '1', '1', '1,15', ',443,445,447,', 0, 0),
(45, 'Rintal ring binder / D20', 'ring binder, A4 format.Print 4/0, glossy finish.Ring D20/02.', '1', '1', '1,5', ',449,450,451,', 0, 0),
(46, 'Porta ring binder / D16', 'ring binder, A4 format.Print 4/0, matt finish.Ring D16/02.', '1', '1', '1,8', ',452,453,454,', 0, 0),
(47, 'Warta ring binder / D16', 'ring binder, A4 format.Print 4/0, matt finish.Ring D16/02.', '1', '17', '1,8', ',455,456,457,', 0, 0),
(48, 'Achilles ring binder', 'ring binder with arch ring.Print 4/0, patterned glossy finish.Ring F75.With RADO holes.', '1', '1', '19', ',500,501,', 0, 0),
(49, 'ring binder Muraspec', 'ring binder, ring D65/02.Fabric covered,Additional element - Screen printing', '1', '1', '0', ',521,522,', 0, 0),
(50, 'Famos ring binder', 'ring binder, A4 format.Print 4/4, matt finish.Accessories - UV varnish, multibend', '1', '7', '1,10', ',816,817,', 0, 0),
(51, 'Warta Smok ring binder', 'ring binder Print 4/0, matt finish,UV varnish', '1', '17', '15', ',822,823,', 0, 0),
(52, 'BRW ring binder', 'horizontal ring binder Print 4/0, matt finish, special format', '1', '7', '8', ',814,815,', 0, 0),
(53, 'Paged ring binder ', 'ring binder A4 format Print 4/0 matt finish Accessories - 2 die-cut pockets for CD', '1', '7', '1,8', ',818,819,', 0, 0),
(54, 'Archon folder', 'folder, A4 format.Print 4/0, matt finish', '2', '1', '1,8', ',832,834,837,', 0, 0),
(55, 'LOTOS folder', 'folder, A4 format.Print 5/1 matt finishAccessories: plastic sides', '2', '14', '1,20', ',830,831,', 0, 0),
(56, 'Converse folder', 'folder, A4 format.Print 4/4, matt finishAccessories: plastic sides, elastic band', '2', '11', '1,10', ',824,825,', 0, 0),
(57, 'Gdańsk 2000 folder', 'Gdańsk 2000 folderPrint 5/5, gold. Glossy finish.Accessories - magnet closure.', '2', '13', '21', ',802,803,805,', 0, 0),
(58, 'Teczka testowy', 'Teczka testowy. Dodatkowe elementy: plastikowe boki, gumka.', '2', '1', '1,10', ',784,786,787,788,789,790,791,', 0, 0),
(59, 'Amgen folder', 'folder Amgen, A4 format.Print 4/0, matt finish.Accessories: pocket for documents.', '2', '9', '1,8', ',565,566,', 0, 0),
(60, 'Polish Radio folder', 'folder, A4 format.Print 4/0,matt laminate.Accessories: magnet closure.', '2', '8', '1,16', ',594,595,597,', 0, 0),
(61, 'Paged folder', 'folder with handle, Print 4/0, matt finish.Accessories: spot UV varnish', '2', '7', '8', ',572,573,577,', 0, 0),
(62, 'Bank Pocztowy accordion folder', 'accordion folder, A4 format.Print 4/0, matt finish.Accessories: separators with index tabs', '2', '5', '1,8', ',561,562,', 0, 0),
(63, 'LOTOS folder', 'folder, A4 format.Print 4/0 matt finishAccessories: arch ring', '2', '14', '1,8', ',540,542,544,', 0, 0),
(64, 'Tikkurila folder', 'folder, A4 format.Print 4/4, glossy finish kalandrowanaAccessories: przegroda tekturowa, wkładka z pianki PE', '2', '1', '1,22', ',515,516,', 0, 0),
(66, 'box Porta', 'box for documents or samples.Print 4/0, matt finish.With plastic corners.', '4', '1', '8', ',99,352,', 0, 0),
(67, 'box Achilles', 'box for CDs, cards or other collections.Print 4/0, glossy finish.', '4', '1', '5', ',103,353,354,', 0, 0),
(68, 'The Saint slipcase', 'slipcase for CD/DVD.Print 4/0, matt finish, UV varnish', '4', '8', '15', ',137,337,338,', 0, 0),
(69, 'Le Charme slipcase', 'slipcase for ring binder.Print 4/0 , patterned glossy finish.', '4', '11', '19', ',135,324,325,326,327,328,', 0, 0),
(70, 'Achilles slipcase', 'ring binder slipcase. Print 4/0, matt finish.', '4', '1', '8', ',250,340,341,342,', 0, 0),
(71, 'Ceramika Gres sample folder', 'sample folder, special format.Print 4/4, matt laminate.Accessories: separator.', '6', '1', '23', ',172,410,411,412,', 0, 0),
(72, 'sample folder', 'sample folderPrint 4/0, gloss laminate.Accessories: polyurethane foam pad for samples.', '6', '1', '17', ',174,', 0, 0),
(73, 'Kabe sample folder', 'sample folder for plaster.Print 4/0, patterned glossy finish.', '6', '1', '19', ',164,408,409,', 0, 0),
(74, 'Achilles business card folder', 'business card folderPrint 4/4, various laminates, UV convex varnish.Ring R20/04Accessories: business cards pockets, index tabs.', '9', '1', '24', ',460,508,', 0, 0),
(75, 'business card  Archon', 'business card folder Print 4/0, matte laminate.Ring: R20/04Accessories: business card pockets, index tabs.', '9', '', '', ',129,406,407,', 0, 0),
(76, 'Polypropylen folder', '', '10', '', '', ',produkty_PP1,produkty_PP1,', 0, 0),
(77, 'Leaflet dispensers', '', '11', '', '', ',ulotkownik1,ulotkownik1,', 0, 0),
(78, 'Ving Parmar', 'description', '2', '', '0', ',segregator-ving,', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `produkty_se_old`
--

CREATE TABLE IF NOT EXISTS `produkty_se_old` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(256) NOT NULL,
  `opis` text NOT NULL,
  `kategoria` tinytext NOT NULL,
  `branza` tinytext NOT NULL,
  `cechy` tinytext NOT NULL,
  `zdjecia` tinytext NOT NULL,
  `prototyp` tinyint(1) NOT NULL,
  `logowanie` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Zrzut danych tabeli `produkty_se_old`
--

INSERT INTO `produkty_se_old` (`id`, `nazwa`, `opis`, `kategoria`, `branza`, `cechy`, `zdjecia`, `prototyp`, `logowanie`) VALUES
(1, 'Etui na dokumenty podróży', 'Etui na dokumenty podróży - Prototyp Achilles Polska', '2', '16', '0', ',984,985,', 0, 0),
(2, 'Teczka na dokumenty samochodu', 'Teczka na dokumenty samochodu - Prototyp Achilles Polska', '2', '10', '1', ',982,983,', 0, 0),
(3, 'Teczka Peugeot Bank', 'Teczka Peugeot Bank. Dodatkowe elementy: kieszeń sztancowana na dokumenty, gumka zamykająca. ', '2', '10', '1,5', ',853,854,855,', 0, 0),
(4, 'Teczka Matopat', 'Teczka wielobigowa. Dodatkowe elementy - pudełka z polipropylenu stanowiące boki teczki, mechanizm. ', '2', '9', '3,4', ',849,850,851,', 0, 0),
(5, 'Teczka Domowe Klimaty', 'Teczka wielobigowa.', '2', '1', '1,6', ',847,848,', 0, 0),
(6, 'Teczka Citroen Bank', 'Teczka Citroen Bank. Dodatkowe elementy: kieszeń sztancowana na dokumenty, gumka zamykająca.', '2', '5', '1,5', ',844,845,846,', 0, 0),
(7, 'Teczka CDS GROUP', 'Teczka CDS GROUP.', '2', '3', '1,5', ',842,843,', 0, 0),
(8, 'Teczka BANK BGŻ', 'Teczka BANK BGŻ. Dodatkowe elementy: zamknięcie na magnes, mechanizm ringowy, wireclip, uchwyt na długopis, notes. ', '2', '5', '1,7', ',838,839,', 0, 0),
(9, 'Segregator E-szkoła', 'Segregator E-szkoła. Mechanizm R25/04. Dodatkowe wyposażenie: przekładki katalogowe.', '1', '2', '1,8', ',217,362,363,364,', 0, 0),
(10, 'Segregator Florum/D65', 'Segregator Florum/D65. Mechanizm D65/02. ', '1', '3', '1,5', ',304,307,308,', 0, 0),
(11, 'Segregator Allianz/D52', 'Segregator Allianz/D52. Mechanizm D52/02. ', '1', '', '0', ',310,311,312,', 0, 0),
(12, 'Segregator Le Charme', 'Segregator Le Charme.', '1', '11', '9', ',330,331,333,334,335,336,', 0, 0),
(13, 'Katalog Achilles', 'Segregator z etui oraz kompletem kart katalogowych. Mechanizm D20/03. Dodatkowe elementy: lakierowany mechanizm.', '1', '1', '10', ',344,345,347,348,349,350,351,', 0, 0),
(14, 'Segregator Bims Plus/D45', 'Segregator Bims Plus/D45. Mechanizm D45/02. ', '1', '1', '1,5', ',413,414,415,', 0, 0),
(15, 'Segregator Sanplast D40/04', 'Segregator Sanplast D40/04. Mechanizm D40/04. Dodatkowe wyposażenie: kółko na grzbiecie. ', '1', '1', '1,6', ',417,418,419,', 0, 0),
(16, 'Segregator P&G/D35', 'Segregator P&G/D35. Mechanizm D35/02. Dodatkowe wyposażenie: przekładki katalogowe, kompresor, kieszonka na dokumenty, kieszonka na CD.', '1', '15', '1,10', ',421,422,423,424,426,', 0, 0),
(17, 'Clipboard Achilles', 'Clipboard Achilles. ', '3', '1', '1,10', ',106,', 0, 0),
(18, 'Clipboard Interservis', 'Clipboard Interservis, zamykany. Mechanizm: WCL 100, uchwyt na długopis. Grzbiet: wielobig. ', '3', '12', '1,11', ',316,317,481,', 0, 0),
(19, 'Clipboard zamykany Achilles', 'Clipboard zamykany Achilles. Mechanizm WCL 100, uchwyt na długopis. Grzbiet: wielobig.', '3', '1', '1,12', ',470,', 0, 0),
(20, 'Clipboard WOŚP', 'Clipboard WOŚP.', '3', '13', '1,11', ',800,801,', 0, 0),
(21, 'Clipboard PROFI', 'Clipboard PROFI. Dodatkowe elementy - mechanizm lakierowany.', '3', '7', '1,13', ',806,807,808,', 0, 0),
(22, 'Clipboard SKOK', 'Clipboard SKOK. Dodatkowe elementy - mechanizm, bloczki ze stikerami.', '3', '5', '1,11', ',809,810,', 0, 0),
(23, 'Pudełko Achilles', 'Pudełko Achilles na dokumenty, płyty CD lub inne kolekcje.', '4', '1', '5', ',244,', 0, 0),
(24, 'Komplet etui SAPA', 'Komplet 2 etui na materiały reklamowe.', '4', '1', '14', ',720,798,799,', 0, 0),
(25, 'Etui "Zamachy"', 'Etui na DVD.', '4', '8', '15', ',534,', 0, 0),
(26, 'Etui Columbo', 'Etui na okładkę do płyt CD/DVD.', '4', '8', '15', ',526,527,', 0, 0),
(27, 'Prezenter LMI', 'Prezenter LMI. Uszlachetnienie - kalander gruby oklejka, kalander drobny wklejka.', '5', '1', '1,11', ',811,812,813,', 0, 0),
(28, 'Prezenter - etui na soczewki JZO', 'Prezenter dostosowany formatem do potrzeb klienta. Dodatkowe elementy - zapięcie na magnes, wkładki z pianki na soczewki, kieszeń wklejana. ', '5', '9', '8', ',506,507,', 0, 0),
(29, 'Prezenter Gala', 'Prezenter dostosowany formatem do potrzeb klienta. Uszlachetnienie - kalander gruby. ', '5', '7', '11', ',490,491,494,495,', 0, 0),
(30, 'Prezenter Master Card', 'Prezenter dostosowany formatem do potrzeb klienta. Prezenter wyposażony w tablicę do pisania, marker oraz gąbkę. ', '5', '5', '5', ',155,319,320,321,339,', 0, 0),
(31, 'Etui na soczewki okularowe', 'Etui na soczewki okularowe - Prototyp Achilles Polska', '6', '9', '0', ',986,987,', 0, 0),
(32, 'PAGED wzornik tkanin', 'Wzornik tkanin. Dodatkowe elementy: dwa mechanizmy do umieszczenia próbek.', '6', '7', '16', ',820,821,', 0, 0),
(33, 'GINTARO wzornik tkanin', 'Wzornik. Dodatkowe elementy: wkładka z PCV spienionego - wieszak.', '6', '7', '17', ',770,771,772,', 0, 0),
(34, 'Wzornik GLASS MIX', 'Wzornik, format specjalny. Druk 4/4, błyszczący ,kalander. Dodatkowe elementy: zakładki zabezpieczające', '6', '1', '18', ',694,695,701,', 0, 0),
(35, 'Okładka na zwolnienia L4 Advantan', 'Okładka na zwolnienia lekarskie L4. Zastosowano gumkę zamykającą oraz przekładkę zapobiegającą samokopiowaniu. Mechanizm WCL 100. ', '7', '4', '10', ',792,795,', 0, 0),
(36, 'Okładka na zwolnienia L4 Pharma Nord', 'Okładka na zwolnienia lekarskie L4. Dodatkowe elementy: gumka zamykająca oraz przekładka, mechanizm WCL100.', '7', '4', '10', ',550,551,552,', 0, 0),
(37, 'Receptariusz Spuriva', 'Okładka na recepty (receptariusz). Zastosowano gumkę zamykającą. Mechanizm WL 100.', '7', '9', '11', ',96,358,359,', 0, 0),
(38, 'Okładka na zwolnienia L4 Aspirin', 'Okładka na zwolnienia lekarskie L4. Zastosowano gumkę zamykającą oraz przekładkę zapobiegającą samokopiowaniu. Mechanizm WCL 100.', '7', '4', '10', ',88,355,356,357,', 0, 0),
(39, 'Pudełko na wino pionowe z klapką', 'Pudełko na wino pionowe z klapką - Prototyp Achilles Polska.', '8', '1', '0', ',976,977,978,979,', 1, 0),
(40, 'Pudełko na wino z przykrywką z okienkiem', 'Pudełko na wino pionowe z przykrywką z okienkiem - Prototyp Achilles Polska.', '8', '1', '0', ',980,', 1, 0),
(41, 'Pudełko na wino - tuba', 'Pudełko na wino pionowe w formie tuby - Prototyp Achilles Polska.', '8', '1', '0', ',981,', 1, 0),
(42, 'Teczka DRE', 'Teczka - wzornik szkła. Dodatkowe elementy - wzmocnienie ścianki tylnej. ', '2', '1', '8', ',827,828,829,', 0, 0),
(43, 'Segregator Philips/D30', 'Segregator Philips/D30. Mechanizm D30/02. Dodatkowe wyposażenie: kompresor. ', '1', '3', '1,11', ',439,440,441,', 0, 0),
(44, 'Segregator Gaspol/D25', 'Segregator Gaspol/D25. Mechanizm D25/02. ', '1', '1', '1,15', ',443,445,447,', 0, 0),
(45, 'Segregator Rintal/D20', 'Segregator Rintal/D20. Mechanizm D20/02.', '1', '1', '1,5', ',449,450,451,', 0, 0),
(46, 'Segregator Porta/D16', 'Segregator Porta/D16Segregator, format A4. Druk 4/0, folia matowa. Mechanizm D16/02. ', '1', '1', '1,8', ',452,453,454,', 0, 0),
(47, 'Segregator Warta/D16', 'Segregator Warta/D16 format A4. Druk 4/0, folia matowa. Mechanizm D16/02. ', '1', '17', '1,8', ',455,456,457,', 0, 0),
(48, 'Segregator Achilles', 'Segregator z mechanizmem dźwigniowym. Mechanizm F75. Zastosowano kółko na grzbiecie i zapięcie RADO.', '1', '1', '19', ',500,501,', 0, 0),
(49, 'Segregator Muraspec', 'Segregator Muraspec. Mechanizm D65/02. Oklejany tkaniną. Dodatkowy element - sitodruk.', '1', '1', '0', ',521,522,', 0, 0),
(50, 'Segregator Famos', 'Segregator Famos. Dodatkowe elementy - lakier UV, grzbiet wielobigowy .', '1', '7', '1,10', ',816,817,', 0, 0),
(51, 'Segregator Warta Smok', 'Segregator Warta Smok.', '1', '17', '15', ',822,823,', 0, 0),
(52, 'Segregator BRW', 'Segregator "poziomy" z mechanizmem. Specjalny format tektury.', '1', '7', '8', ',814,815,', 0, 0),
(53, 'Segregator Paged', 'Segregator Paged. Dodatkowe elementy - 2 kieszenie na CD.', '1', '7', '1,8', ',818,819,', 0, 0),
(54, 'Teczka Archon', 'Teczka Archon', '2', '1', '1,8', ',832,834,837,', 0, 0),
(55, 'Teczka LOTOS', 'Teczka LOTOS. Dodatkowe elementy: plastikowe boczki.', '2', '14', '1,20', ',830,831,', 0, 0),
(56, 'Teczka Converse', 'Teczka Converse. Dodatkowe elementy: plastikowe boki, gumka.', '2', '11', '1,10', ',824,825,', 0, 0),
(57, 'Okładka Gdańsk 2000', 'Okładka Gdańsk 2000. Dodatkowy element - zapięcie na magnes.', '2', '13', '21', ',802,803,805,', 0, 0),
(58, 'Teczka testowy', 'Teczka testowy. Dodatkowe elementy: plastikowe boki, gumka.', '2', '1', '1,10', ',784,786,787,788,789,790,791,', 0, 0),
(59, 'Teczka Amgen', 'Teczka Amgen. Dodatkowe elementy: kieszenie sztancowane na dokumenty.', '2', '9', '1,8', ',565,566,', 0, 0),
(60, 'Teczka Polskie Radio', 'Teczka Polskie Radio. Dodatkowe elementy: magnesy zamykające.', '2', '8', '1,16', ',594,595,597,', 0, 0),
(61, 'Teczka Paged', 'Teczka z rączką. Dodatkowe elementy: lakier punktowy UV.', '2', '7', '8', ',572,573,577,', 0, 0),
(62, 'Teczka harmonijkowa Bank Pocztowy', 'Teczka harmonijkowa Bank Pocztowy. Dodatkowe elementy: przekładki z registrami.', '2', '5', '1,8', ',561,562,', 0, 0),
(63, 'Teczka LOTOS', 'Teczka LOTOS. Dodatkowe elementy: mechanizm dźwigniowy.', '2', '14', '1,8', ',540,542,544,', 0, 0),
(64, 'Teczka Tikkurila', 'Teczka Tikkurila. Dodatkowe elementy: przegroda tekturowa, wkładka z pianki PE.', '2', '1', '1,22', ',515,516,', 0, 0),
(65, 'Clipboard', 'Clipboard', '3', '2', '1,10', ',781,782,', 0, 0),
(66, 'Pudełko Porta', 'Pudełko na dokumenty lub próbki. Zastosowano plastikowe narożniki.', '4', '1', '8', ',99,352,', 0, 0),
(67, 'Pudełko Achilles', 'Pudełko na płyty CD, karty lub inne kolekcje.', '4', '1', '5', ',103,353,354,', 0, 0),
(68, 'Etui Święty', 'Etui na okładkę do płyt CD/DVD.', '4', '8', '15', ',137,337,338,', 0, 0),
(69, 'Etui Le Charme', 'Etui na segregator.', '4', '11', '19', ',135,324,325,326,327,328,', 0, 0),
(70, 'Etui Achilles', 'Etui na segregator.', '4', '1', '8', ',250,340,341,342,', 0, 0),
(71, 'Wzornik Ceramika Gres', 'Wzornik, format specjalny. Dodatkowe elementy: przekładka zabezpieczająca. ', '6', '1', '23', ',172,410,411,412,', 0, 0),
(72, 'Wzornik', 'Wzornik. Dodatkowe elementy: wkładka piankowa do umieszczenia próbek.', '6', '1', '17', ',174,', 0, 0),
(73, 'Wzornik Kabe', 'Wzornik tynków.', '6', '1', '19', ',164,408,409,', 0, 0),
(74, 'Wizytownik ', 'Wizytownik Achilles. Mechanizm R20/04. Dodatkowe elementy: kieszonki na wizytówki, skorowidz. ', '9', '1', '24', ',460,508,', 0, 0),
(75, 'Wizytownik Archon', 'Wizytownik Archon. Mechanizm: R20/04. Dodatkowe elementy: kieszonki na wizytówki, skorowidz. ', '9', '1', '16', ',129,406,407,', 0, 0),
(76, 'Teczka', 'Teczka z polipropylenu', '10', '1', '1', ',produkty_PP1,produkty_PP1,', 0, 0),
(77, 'Stojak na ulotki Archon', 'Stojak na ulotki Archon', '11', '1', '1', ',ulotkownik1,ulotkownik1,', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `prototypy`
--

CREATE TABLE IF NOT EXISTS `prototypy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa_pl` varchar(256) NOT NULL,
  `nazwa_en` varchar(256) NOT NULL,
  `nazwa_se` varchar(256) NOT NULL,
  `nazwa_no` varchar(256) NOT NULL,
  `widoczna_pl` enum('tak','nie') NOT NULL,
  `widoczna_en` enum('tak','nie') NOT NULL,
  `widoczna_se` enum('tak','nie') NOT NULL,
  `widoczna_no` enum('tak','nie') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `prototypy`
--

INSERT INTO `prototypy` (`id`, `nazwa_pl`, `nazwa_en`, `nazwa_se`, `nazwa_no`, `widoczna_pl`, `widoczna_en`, `widoczna_se`, `widoczna_no`) VALUES
(1, 'Prototyp 1', '', '', '', 'tak', 'tak', 'tak', 'tak');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `uzytkownicy`
--

CREATE TABLE IF NOT EXISTS `uzytkownicy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `temppassword` varchar(40) NOT NULL,
  `datarejestr` int(10) unsigned NOT NULL,
  `dataedycji` int(10) NOT NULL,
  `newsletter` enum('yes','no') NOT NULL DEFAULT 'no',
  `imie` varchar(255) NOT NULL,
  `nazwisko` varchar(255) NOT NULL,
  `firma` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `wojewodztwo` tinytext NOT NULL,
  `aktywne` enum('yes','no') NOT NULL DEFAULT 'no',
  `jezyk` enum('pl','en','se','no') NOT NULL DEFAULT 'pl',
  `admin` set('not','pl','en','se','no') NOT NULL DEFAULT 'not',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `email`, `password`, `temppassword`, `datarejestr`, `dataedycji`, `newsletter`, `imie`, `nazwisko`, `firma`, `adres`, `telefon`, `wojewodztwo`, `aktywne`, `jezyk`, `admin`) VALUES
(1, 'pawel.szparaga@gmail.com', '29fb4687db8e6ee069b356b26465465830c0da3e', '10fe2be86d419b39d643583a08da36bf7d8022dc', 0, 1360233232, 'no', 'Paweł', 'Szparaga', 'fdsdf', '', '', '10', 'no', 'pl', 'pl,en,se,no'),
(2, 'tomasz.kolaszynski@usable.pl', '29fb4687db8e6ee069b356b26465465830c0da3e', '', 0, 1360244087, 'no', 'Tomasz', 'Kolaszyński', 'Achilles Polska', '', '', '10', 'yes', 'pl', 'pl,en,se,no'),
(56, 'malgorzata.gulgowska@achilles.pl', '14084996b4b2a07641ebdef42c8d75cbb644f606', '', 1357894395, 1358086254, 'no', 'Małgorzata', 'Gulgowska-Kowalska', 'Achilles Polska', '', '667829810', '1', 'yes', 'pl', 'pl,en,se,no'),
(63, 'pawszp@wp.pl', 'faa1e9b77ae0c1773d971aae0057eee642a7ab42', '', 1358510869, 0, 'yes', 'Paweł', 'Szparaga', '', '', '600600600', '', 'yes', 'en', 'not'),
(65, 'kontakt@gryf.olsztyn.pl', 'c18337759e6993ecdf2d956ba5e25b2d1bf575e5', '', 1359491149, 0, '', 'Grzegorz', 'Sokołowski', 'Przedsiębiorstwo Produkcyjno-Reklamowe GRYF Grzegorz Sokołowski', '', '609466050', '11', 'yes', 'pl', 'not'),
(66, 'kokodesign@interia.eu', '', '', 1359804125, 0, 'yes', '', '', '', '', '', '', 'yes', 'pl', 'not'),
(67, 'litar@litar.pl', '5b2fb9891083d0c6a8c90ba82d8aae22f0c61d70', '', 1360046696, 0, 'yes', 'Lucjan', 'Furman', 'LITAR Sp. z o.o.', '', '77 456 20 88', '7', 'yes', 'pl', 'not'),
(68, 'wiesia@pracownia.pl', '5f99e7a0d6009c1836bef2cc911671a23f442681', '', 1361347753, 0, 'yes', 'Wiesława', 'Górska', 'Pracownia spółka z o.o.', '', '600250520', '10', 'yes', 'pl', 'not'),
(69, 'annapolecka@gmail.com', 'c7999ff52426151f1a33a6416086da7856d57cb2', '', 1362423061, 0, 'yes', 'ANNA', 'POLECKA', '', '', '500276599', '9', 'yes', 'pl', 'not');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `zamowienia`
--

CREATE TABLE IF NOT EXISTS `zamowienia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typ` varchar(256) NOT NULL,
  `funkcja` varchar(256) NOT NULL,
  `komentarz` text NOT NULL,
  `email` varchar(256) NOT NULL,
  `data` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Zrzut danych tabeli `zamowienia`
--

INSERT INTO `zamowienia` (`id`, `typ`, `funkcja`, `komentarz`, `email`, `data`) VALUES
(1, 'typ prototypu', 'do wykorzystania wewnątrz firmy', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. fffffff', 'pawel.szparaga@gmail.com', 1354796661),
(2, '', '', '', '', 1354797552),
(3, '', '', '', '', 1354797558),
(4, 'typ prototypu', 'do wykorzystania wewnątrz firmy', 'qqqqqqqqqqqqqq', 'pawel.szparaga@gmail.com', 1354797615),
(5, 'typ prototypu', 'jeszcze inna funkcja', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore q', 'pawel.szparaga@gmail.com', 1354797668),
(6, 'typ prototypu', 'prezent dla klientow', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ', 'pawszp@wp.pl', 1354798151),
(7, '/prototypy/zamow,typ-prototypu.html', 'jeszcze inna funkcja', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ', 'pawel.szparaga@gmail.com', 1354798510),
(8, 'typ-prototypu', 'jeszcze inna funkcja', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ', 'pawszp@wp.pl', 1354798570),
(9, 'typ-prototypu', 'prezent dla klientow', 'asdas', 'tomek@usable.pl', 1354883987),
(15, '', 'prezent dla klientow', 'Yes   how we  controlled Solartwin suclessfulcy for 7 yrs. But you must start the pump at over 10% sunlight, increase speed linearly with light levels and run it very slow, even in full sun, to minimise risk of heat export when the panel is cooler than the water feeding it. A controller removes these (OK) marginal constraints, allowing faster, nonlinear pumps starting at lower light levels only when the controller allows. Using the controller on Solartwin may give 1-10% more energy a year.', '', 1360562054);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `zapytania`
--

CREATE TABLE IF NOT EXISTS `zapytania` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imie` varchar(256) NOT NULL,
  `nazwisko` varchar(256) NOT NULL,
  `firma` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `wojewodztwo` tinytext NOT NULL,
  `zapytanie` text NOT NULL,
  `data` int(10) NOT NULL,
  `wyslanoodpowiedz` enum('tak','nie') NOT NULL DEFAULT 'nie',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Zrzut danych tabeli `zapytania`
--

INSERT INTO `zapytania` (`id`, `imie`, `nazwisko`, `firma`, `email`, `telefon`, `wojewodztwo`, `zapytanie`, `data`, `wyslanoodpowiedz`) VALUES
(1, 'sgfd', 'dsfg', 'dfgs', 'aaa@as.pl', '12345678', '', 'adsfasd', 1354281203, 'nie'),
(2, 'pawel', 'Szparaga', '', 'pawszp@wp.pl', '', '', 'erwer', 1354795948, 'nie'),
(3, 'pawel', 'Szparaga', '', 'pawszp@wp.pl', '', '', 'ryrty', 1354796265, 'nie'),
(4, 'tes', 'test', 'tes', 'aaa@as.pl', '', '', 'stst seet', 1354882980, 'nie'),
(5, 'pawel', 'Szparaga', '', 'pawel.szparaga@gmail.com', '66666666', '7', 'test zapytania', 1355146113, 'nie'),
(6, 'pawel', 'sz', '', 'pawel.szparaga@gmail.com', '5555', '1', 'sprawdzam czy pole ''dzieki za zapytanie'' ma minimum 150px', 1355146462, 'nie'),
(7, 'w', 'w', '', 'pawel.szparaga@gmail.com', '66666666', '4', 'dsfd', 1355146554, 'nie'),
(8, '', '', '', '', '', '', '', 1360274261, 'nie'),
(9, 'Sherlyn', 'Sherlyn', 'KWpNUuZsrvSEO', '', 'nKBIeAJasAvAxbzXO', '5', 'Thanks for helnpig me to see things in a different light.', 1360512320, 'nie'),
(10, '', '', '', '', '', '', '', 1360512321, 'nie'),
(11, 'Jasmeet', 'Jasmeet', 'iOiAgomjRWAhLpn', '', 'auZCYLcSJN', '15', 'Personally, for a new shooter/hunter I would chosoe a .243, .260, 7mm-08 or .308 over a 30-30 any day.A .243 is a very light recoiling round and is more than capable of ethically taking deer out to 300 yards or so, but I feel that a large deer is on the upper end of the spectrum for this caliber.A .308 has a moderate amount of recoil, but carries alot more energy down range. in the right shooters hands, a 308 is fully capable on deer out to 500 yardsThe 7mm-08 is virtually identical (performance wise) to a .308, but recoils less A .260 is a good compromise between .308 and .243. It shoots flat (making range estimation less critical on longer shots) and has light recoil like the .243 , yet carries as much energy as the 308. It is also affected less by wind than any of the other calibers I mentioned As far as ammo availability/price, .308 is going to be the easiest to find and the cheapest, followed closely by .243. The .260 and 7mm-08 will be harder to find ammo for, but not difficult by any means. You will probably pay $3-5 a box more for 7mm-08 or .260.My choice would be a Savage chambered in .260, second choice would be 7mm-08, followed by .308', 1360518946, 'nie'),
(12, '', '', '', '', '', '', '', 1360518947, 'nie'),
(13, 'Siliwangi', 'Siliwangi', 'jWLrRCRVAdnBFL', '', 'LhTAspXMPrbJgL', '10', 'well, it depends on the poesrn, but poesrnally I have an old remington 788 in .308 win, and It drives tacks like it''s going out of fashion, you can get a good one for around $300 maybe less and that comes with a scope because most are used in long range shooting, they are known to be some of the best rifles for accuracy in the world, some people still use them for competition shooting. But you can''t buy them new though because they stopped making them in the 80 s, it came in a bunch of different calbres including .308 winchester, .243 winchester, 30-30, .22-250, .223 remington, and 6mm remington, could be more, the only downside is that they don''t make magazines for them anymore and to get one would probably mean either getting another rifle or being lucky enough to get one for online.', 1360522973, 'nie'),
(14, '', '', '', '', '', '', '', 1360522974, 'nie'),
(15, 'Lizzie', 'Lizzie', 'qOelyokiSmp', '', 'qtigxmvVgxkbWNORHQ', '5', 'tendonitis is a major pain, i''ve had it in my achilles twice and the best move is to rest it. Im asnumisg your cross country season doesnt start until the fall, in which case its better to rest now than later in the season.  Rest  doesn''t mean stop everything, get on a stationary bike/eliptical machine to do a no impact workout, it will keep you cardiovascularly in shape and makes sure that you are still burning calories. You won''t lose too much fitness, and this should prevent something more serious happening to your knee.Additionally:-Ice-Advil-Stretching-MINERAL ICE-Knee Circles -&gt;Will all help', 1360525476, 'nie'),
(16, '', '', '', '', '', '', '', 1360525477, 'nie'),
(17, 'Joyguel', 'Joyguel', 'jvKWpcXbACyIis', '', 'GFutZhVoCjbLz', '5', 'The Marlin 336 with the new Hornady leverution ammo is good for 200 yards on a deer. Most deer are shot in the woods at close range in the east were I live. Average dactinse about 50 yards. Unless you are hunting corn fields or live on the plains a 30-30 is ideal. Low recoil,fast follow up shot and practice ammo is not as expensive as some other deer guns.If it is a bolt action you want look at the Savage in 25-06. Cheap accurate good for 300 yards if you do your part. Both of these rifles have pretty low recoil but enough power to do the job.', 1360525739, 'nie'),
(18, '', '', '', '', '', '', '', 1360525739, 'nie'),
(19, 'Jese', 'Jese', 'hCRngeqISR', '', 'okznTMThVJW', '15', 'I like the Savage rifles not only for their aacruccy and low price but for the many options and calibers they come in. I like 308, 7-08, 270, and 208. It will be up to you which one you can shoot the best. They all probably can out-shoot you but some have more recoil than others so you need to shoot one of each caliber to see which allows you to hit easily with the lest amount of recoil.Sarge', 1360526472, 'nie'),
(20, '', '', '', '', '', '', '', 1360526473, 'nie'),
(21, 'Margaux', 'Margaux', 'JTFUTzAIJcnKs', '', 'WOZbMEvIoToIOxR', '10', '6th is Sica  and siick,  I forget who #1 was, but I reeembmr talking to him(on the forum almost 2 years ago) about that one.  Its just sharpie, but he was thinking about getting a real tat in the same place.   Thankfully I think we talked him out of it.', 1360527987, 'nie'),
(22, '', '', '', '', '', '', '', 1360527990, 'nie'),
(23, '', '', '', '', '', '', '', 1360528304, 'nie'),
(24, 'dfd', 'dfdf', '', 'df@asd.pl', '12341234', '1', '', 1360528436, 'nie'),
(25, '', '', '', '', '', '', '', 1360528641, 'nie'),
(26, 'fdfsdf', 'wwqe', '', 'qqq@ww.pl', '1234', '1', '', 1360528888, 'nie'),
(27, 'fdfsdf', 'wwqe', '', 'qqq@ww.pl', '1234', '1', '', 1360528937, 'nie'),
(28, 'fdfsdf', 'wwqe', '', 'qqq@ww.pl', '1234', '1', '', 1360528972, 'nie'),
(29, 'fdfsdf', 'wwqe', '', 'qqq@ww.pl', '1234', '1', '', 1360529035, 'nie'),
(30, 'tet', 'teet', 'werwer', 'wqe@dsad.pl', '123314', '14', '', 1360829777, 'nie'),
(31, 'piotr', 'korczak', 'torro sp. jawna', 'piotr@torro.pl', '506 118 384', '5', 'witam\r\njestem zainteresowany następującymi foliami. Proszę o podanie cen\r\n\r\nFolia satynowa aksamitna\r\n\r\nFolia błyszcząca wzorzysta\r\n\r\nFolia matowa wzorzysta\r\n\r\nFolia Strukturalna efekt perły\r\n\r\nFolia strukturalna efekt lnu\r\n\r\nFolia Strukturalna efekt skóry\r\n\r\nFolia Strukturalna Efekt Szczotkowanego Aluminium!!\r\n\r\nFolia Strukturalna Efekt Kropki\r\n\r\nFolia okienkowa', 1360841024, 'nie'),
(32, 'Anna', 'Pawłowska', '', 'mail.pawlowska@gmail.com', '510775391', '15', 'Dzień dobry, \r\n\r\n\r\nJestem zainteresowana powyższym modelem wzornika. Chciałam zapytać czy istnieje możliwość zamówienia u Państwa,\r\n&quot;czystego&quot; wzornika, kolor czarny mat wewnątrz i na zewnątrz, z ewentualnym wytłoczeniem logo firmy na okładce w nakładzie ok 50-100 sztuk?\r\nJeżeli tak poprosiłabym o oszacowanie wstępne kosztów.', 1362060485, 'nie'),
(33, 'ANNA', 'POLECKA', '', 'annapolecka@gmail.com', '500276599', '9', 'Witam, czy można zamówić 2 okładki na zwolnienia lekarskie Aspirin?\r\nPozdrawiam\r\nAnna Polecka', 1362503010, 'nie'),
(34, 'Paulina', 'Lajnert', '', 'paulina@mediaessence.pl', '796665367', '12', 'Proszę o podanie wyceny na clipboardy w minimalnym zamówieniu. Pozdrawiam PL', 1362585733, 'nie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `zdjecia`
--

CREATE TABLE IF NOT EXISTS `zdjecia` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `plik` varchar(256) CHARACTER SET latin2 NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
