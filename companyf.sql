-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 08:34 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `company`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmark`
--

CREATE TABLE `bookmark` (
  `bookmark_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `people_id` int(55) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_hour` time NOT NULL,
  `end_hour` time NOT NULL,
  `selected_date` date NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `building_id` int(11) NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buildings`
--

INSERT INTO `buildings` (`building_id`, `building_name`, `description`) VALUES
(1, 'Building 1', 'Main building'),
(2, 'Head Office', 'Principal Building');

-- --------------------------------------------------------

--
-- Table structure for table `building_offices`
--

CREATE TABLE `building_offices` (
  `building_id` int(11) NOT NULL,
  `office_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `building_offices`
--

INSERT INTO `building_offices` (`building_id`, `office_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `office_id` int(11) NOT NULL,
  `office_image` longblob NOT NULL,
  `office_name` varchar(55) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`office_id`, `office_image`, `office_name`, `description`) VALUES
(1, '', 'Office A', 'Main office'),
(2, '', 'Office B', 'Secondary office');

-- --------------------------------------------------------

--
-- Table structure for table `offices_room`
--

CREATE TABLE `offices_room` (
  `office_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices_room`
--

INSERT INTO `offices_room` (`office_id`, `room_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `people_id` int(11) NOT NULL,
  `user` varchar(55) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `role_department_id` int(11) DEFAULT NULL,
  `photo` longblob DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `nationality` varchar(55) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0,
  `password_status` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`people_id`, `user`, `name`, `date_of_birth`, `role_department_id`, `photo`, `password`, `email`, `phone`, `nationality`, `admin`, `password_status`, `active`) VALUES
(16, 'DAnastacio', 'Diogo Ferreira Anastácio', '2024-05-08', NULL, 0xffd8ffe000104a46494600010100000100010000ffdb00840009060713121215131212161615151515151515151715151516151515171615151515181d2820181a251d151521312125292b2f2e2e171f3338332d37282d2e2b010a0a0a0e0d0e1a10101b2b251f252d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2d2b2d2d2d2d2d2d2d2d2d2d2d2d2d2b2b2d2d2d2d2d2d2b2d2d2d2d2d2d2d2d2d2dffc000110800cc00f703012200021101031101ffc4001c0000010501010100000000000000000000030102040506070008ffc40040100001030203040706060004060300000001000203041105213112415161061322327181910752a1b1c1f014426272d1e12333829244a2a3b2c2f1244353ffc400190100030101010000000000000000000000010203040005ffc4002411000301000300020202030100000000000001021103122131410413225132617114ffda000c03010002110311003f00eb0a34ecba9086f513400a28ecef22a7dd45875f25217200eba54d4a171c2a50902544e1c1382684e0880784e09a13822851e12848aa319e93d352dc4b20da1f91bda7f98dde764d9a065c272e598bfb537694d1068f7a4ed1ff006b721ea566ea3a7f5cff00f88201bf75ac6fa585d5170d315d1ddd0de170883da05737fe209fdcd63be6dbad7f477da8b5d66d5b436f975ac06dfea667ea3d10be0ac3bb23a14ba2ae958495674f33646b5ec70735c2ed7037041de0a73a30b07270f6616b4151ded9a94820592ba4b2ac3e938c22cd3868b92a8f13e91b180d8aace9562a40b05cfeaab4b8e652767c9f1f04af933c46f0f4943b7851e1ad6976ab022a08de98fc45c34297ff00392fd8d9d2ea835cd2b8ff004be84366716e8735750f4824196d64a3573bacb93992a909f1b1bb698595a84f8959e210ec950095aa5e8e427b5791640bc884fac6e9ae4b74d2b39a448754708116a8e171c3928481382e00a12d9782759101e09cd480278089cc50a2e2789c54ec324cf0d68d38b8f068de5071fc5d9490ba57e76c9add369c741f5f00570fc771c92a643248e249d067668f75a3705588ec23668fa4fed0a698b9901eaa3d32ff00308e2e76ef01ea56126a827537bf9a475d34309cbef55aa529f81701ba44ddbe0a53281eeb6c8d782b5a6e8c3cd89b0df9fde49bb23ba9404db3bfdf8246496dde4b627a3437bb70d07050ddd191eff865f5baeee8ee9a3ba23d319a8de03497464f6a227b27896fbaee6176ec171a8aae3eb2175c68e07bcd3ad9c3ec2e132746ddb9c0e5e19ab1e8fd75461d209364969c9edbf65e06eb8dfc382872c2b5b3f20f64ee850671920e1f883268d9230ddaf6870f3dc79a7cf264bcce46b18e62fa494f7bac1564241c974bc5a1dad564b12c3067b3a849f8eda33d2324e7d9064729d534aa14911056d4c9e0c013dd3d931ee516591374d3883883f68aae2c5692e6a29627ebe145446ea579485e4be8da7d3a91c9535ca06b12139a38408b547089c3c2784d6a78440284e01204f01101e01382f04a1114e63ed72bcf591420e4d61791cde6c2fe4df8ae692b96c3da6497ae946e688dbff4da7eab1c755aa3c9025a3a26fd15bd352b6c0db7792ab8c7dfdfde6ae299d90f042e8ac49614ad0392d0405bb2165d9258ab382ab2514f18f50593ca8d33930cd74e2d5d5674c020e53a95ed702c70041dc545ea53d8cb153fd8d06b89345ae0351f850e8413b37db603a341ef007c6cae1d8c5d67a506c0f0d7efd1447d55965e49ed5a60e5d9ac3452555f52abeb1ed19dc2a87e225575455dcea9e2309bb07544125574c11e699429a45694210ea5caae6933536a8a8063bad2be06486f58bcf4f112f38648fc8c447a54e2335e5d81d3e9e4852a458cda799aa30406ea8e11387b51026353c22803c2784d6a784c2b3c13805e012a2038bfb4ea7d9ae93f5b6377fc81bf36959111f15d23dacd25a6865dcf8cb2fc0b1d7f93fe0b001c1555783c206c894e89c020009a12b2d24f8dd9a97082ab69da6eaea9a34ac66161054c8c2463422b22cd4eb0694c735a824d8a3bee8728005c90a63341daebc6fe4d27d3359d9a75730d4b1c1cc0e04b98f68008d4b4d9659b22750797f94ff920ee90951e47a57caa24932acc98c7b9ca3bca76da148f4ea429809d46013aa24406c89bae1441a4c94495e89248a2bf35db8360c7397934b57976b09f51a44abcb21b46b7546082dd51da89c11a8810da881140081382684f099083828f88d47550c927b91bde2fa5dad247c94855fd238cba9276b7531496ff0069c913bece458bf4866aa8bab9dd7b3b680b36c1c0119102e3227259b66b656188b0860d9d4e7eaa241da6df81b279669a84be0704f6b2d994079cd79d23b70b8e09982457d4c84da36fafcd141aad6e6dfa77792872c72bcf648671ef5fe4ac705c31c1e0cee3232e090d7961b0bdc73be437256f17d073fe8ea5c46669edfa9fe16a70fac6bdb73c3e2b2d8a401af263168f7b5cfbb871b5867f79a7610e75ed736fa28dcf65a561e1b68581c7eaa971a315c07cc1bcb7ff0048b5b50e6c5661b13f988bdbcb7aced160ed7ca5ef7904e441682d232fcae075b2489cf5b0dbdf12351d1fa0a4246cbc975efb46e05c8b659582cbd7b366695a346c8f03c03880b5f4f84c3d689a4717cc6ddab8072d320465c9657a402d5337ef27fdddafaa787afe4c1f993891575122842446a82a295aa7c460483ba5407ca8723d4725320a43a57211365e73935c506ca2411b11297a9b2954a96b2c14b758d5e101ec5e4d9245e5414fa71797979633708d46082d46089c11a8810da88d4500204f6a684f09d08284a45f23a15e095700e238b5118ea1f1db388b9b9e8e61ee9bee36215338d816e7903a8b1e2bb174afa31f89edc4e0c96d637170fb0ec839e4775f3cbc1724c628e688da481f15c3ac5e367688c8ecf1198cc659a326857ab0ab8f3375269d849b28711eca954f5202a5060bda7c1839b7b01e01a3e891d84dbf315330cae04053679c596775e97ea51494200d093f04fc2a9ececc1b94f6d55e4b38d86eb6fe2ade29616d9cd7175b71b59174729611d4b7162140650bb3cad6dffd2bd824eb0dc68778cf3459294b438bac32de6c49dc0052aa5be07ab5f25553c3b39acff4d59695927ffa305ff730d8fc36569e99db46c42c9fb43c41a66642dffea69dafdcfb1b7a06faa6e26fb99bf2d2e866e67a187203e44f89cb533cdc164620bdaa53902408af0046704964f704d2e42a8a243e29b657a59b69477948d729a6168f392a63dcbc9bb1d87d44912a42b39ac5622842622844e08d446a1b511a8a00509e0a604b745b107a54c053821a70ab9efb5a60ff00e39b8bda516df9ec906de217415c5bda9e204628184f6453c42dc1db723bd73f88467d7815f26419a11c0a1069d52553f6643c0a914a41f35a19692661b31b81a6f277586a519f88f596ed1d9dd96bccff000838710d78be9a1f344fc23992000d9b7ef5af66906d90e06de5752c5a5b5e1264634b3b37bee55cca2901dab59be6085a9c17069e50c21f196388ed0b9b020d9db26c6d70471d16869ba3351a1d8ef16efb76743a6854dda432cfb667b0baf923b362ef96e4e76601f0de7c7d14aa4a4ab24975dc75b937bf32b65857471c33786820db2f98cb458dc7eb67a99258038369848e68d8b832358764edbaf7702edc2c2ca61d54fc7a0b029c8ad7024189b1758e37b805a5db4e07865bb82e715d58e9a47caed647b9e796d1bdbcb4f25d1f13a5fc3d2481b9493811b7f4c43bc7cf4ff52e6b3c0599155e36be4c3f935ad4812891b90ca456d336128ca86f7a1b0a3b62274537415201c505e549960235082e8d52b334e0257aca408531f190a0e9048cf5e4e705e45070fa91214a90a4341e623350a345089c11a8ad436a23514284086f7d93c940982973d353e0a3d925d1daa1d3354d6a9f0374b59c2397ccdd3cab74b5924aed5ce3e5b24b401e0005dc3da37488d1d3131ff9b25c338b5b701ef1cc5c7aae0b893bac6827539dcf13a8279adfc10f7b0ad91bf17d636c7bc3e3cd3a86b764e7c554bae0f023e09e25beb93be0555a28a8d63670730ade9a7da6f31f1e4b0d05616f2e216830bad0742a552688b4cd650cacbed0718dd97685c025bdddb008bd8e856c30ec4646d8f68e77ca4246633c9c0ff4b9cb64b1b8f8abcc3b19d96e4c75f85f2f150b4fe5174a5ff91b5abab9a763a21935c2cecc971b8cc0c858155f534b15332eeeec6dbbb99be4d1cc921370dc6dc05dc003c8dd43c5a6326c039edc85e4710c1903e641f2517bf62f252897d578549eb67da965162eb6c37dd8ff0028f89f559cc670a2730335d062a72468a54381871bb8245cd8f4f29ed3d3894d44f69cda7d10fab3bc2ee35d81c65a7b2161b13c03b6435baaa4f3f638c335b9ab9a187b3a2b9a4e8abb6b3192be660458deee4bab9921d18f9e92ed558ea6e4b4d530f6f646855fe1f83308eea7be5c903f939fd3529710ddeacaa7a36760b9ba8dcb572747031fb414ad901a41e0567eff00680d9c91f4a414aaf2b61ff10db894ab526369de9214a9ae40b8ac466a0468ed5cfe4e0ad446a1b511a990ac204d704e09db2854ea146b18818a6231d3c6e965759a3d493a340de4a256d5b218dd248ed96b45c9fa0e24f05c7ba538f3eae4db75dac6dc471ee68e278bcff49f8b8b5e216ab0aee9763cead99d25ac0761ace0c0483e6733e6b293bec6cecda458fd0a262b51b12078be606d8f77703e764dab01ecb8dfa78f02b7cca4b113dfb2beb28ed91d7f2bb738702ab6465b22ac63989691de0dc9cc3a8237b7784094870e2388efb7911bc20d21d10b68a994357b07928ce66f198e23ebc130153c19336d458a348ccab7c3ea58e3ae575ce20948df656d455bb39ed804660126e401b86f2a75c69a2f3cdfd9d3595918de0594083a53036b075aed98837603ad71b44dc977e9e6b04ec58b8f69f6cb3cf9aa6c4ab36dd964069eba953fd138f44e4e4ecb0fa829e26b8073082d22e08cc107782158c2c165cc7d89626e929e481cebf56e0e603a86bc66072b8f8aea71c26cbcebe2716e494a2255c602a56c0d2ebd95bd7b4a814509b9be89520b43e9e01c102a2d72ac5ed03454f54d76d640a6940f82826a1bcd70320b498650a4c36005c6eae030374469ef82e009d82cb9c74af11eadc40df92d8e3f8bb2269bb805ca313acfc44c2da5d69e3e34d6b0bf46c113a425d9e6bcb6581e1576e8bc96b95264db67474d725091c9cd62c48cd41851da89c11a8ad436a2353214784cacab644c3248e0d6b45c93f21c4f241c42be38233248eb347a93b801bcae59d23c7df54fbbaed8dbdc8c68399e2ee6a932e846f0774aba46faa75cddb134f619ff0093b8b8fc34f1c7d6d659c47e6cac3803bca2d7d658388d5a333b9b7d3c5df254ec7687321c4104eb716bb7ef7db9addc70a519dbd609bfe63c1cc5f65d7e072ba83d618f23dcbd8fe970dde0a7462f2bc7bd9fae6835d1d9d73987e4efdc32cfc53521a5916a63bb83d86cfdc773b91e69afa7cefa03983c0ef0875103982e2e59f16ff5cd2c159f95d9f3fe54bcfb2831dd93dbbfee1f51bd2be1045f51ef37ead522621cdb5afe19fc3550e92701db2723c47d421e04149111cc71084029d57d9767ea133aa045ce5cc69e61239f4e1ac635fdef5191fefcd47aba6746ed975f301cd245b69a74701c0ab2c3e88b9d679d96b46dc8ef763199e3e9624e40037b2838ae206794c874ecb18df763600d8d8333a340f3b94b4fdc087c1b14969de2489ee638685a6c7fb1c8afa87a0d8d1ada28a77801e416bc0d369a4b491c2f6bdb72f94a0759c1759f61b8d18aae4a673bb13b769809cbac667973236bd024e45a8e476e9a0da0a03a0b3ad656c872477b2cd5c498c995fd420cb483556a610bcf8814af8bc0ea33a006b94e734ecdec9eda1064cc643356b6539e1ec2d2c386fb4379d567fa2386be67f6468755a8f6c14e62945bbafd391e0aebd9861cdea9a6da8b9f12b4caebc6089fa34185e0ee6345ecbcb5ad8c0dcbca2f8343fc4a86a47240bce4e38e84eaa4354680e6a4b51382b57a79db1b1cf7901ad1724ee0815958c8586491db2d1a9f900379e4b98749fa4cfa975bbb103d965f5fd4f3bcfcbe74896c4a787ba478f3aaa42e370c1711b380e3fb8eff00e96665aabbb641b0d091bbf4b4f1e688e25c0d9d66f1d1c790e039eaabaa08032cb656e8e3c46677b587b1c91ad8cb1a3550d8cbc2d2353ff70197a80426e2aebb8fed6fc913b91b46fb87798bd80e77ddc9585cc4888d776c1e201fe7ef9a9951007b0b78e63c55648ecc5b75f8efb71f05634d2dc251da2b6371d0ea3223885167a5b1bb7c4787871569884363b63cfc10c30116dc730781e291ad1d32b0551045c65c42654bc38e676871fcc398fe13e6b8371911de0871c5d613b360ed6da03fc1531c6cd2139120db4211a1196b96a7911bbcd456c799be5c95be0b44669591ded73771e0d02e4f93413e4bbe3d672f43d7c2e8a9383e63b6fe3d50eeb79026e78d9834073cd48dfeb985bfc6a2eb092059ba3470681668f201622480d9cddec3f0499e696e58eb8002bfe89cef6d5d33987b4d96375fc1c09f2b2cf35cb51d1980b43e6033ce18bf73876dfe01a7d5c10fa248fa5ba398dc75908963f07b7dd70d4786f1c8ab55c83d95d775351d4deed91a6e73b6db6c45870036975e054ab13c405b9e8a9084a9ae364ac235aded2228a2a06d909ee9825968ea7fd9cdbdb6440c0d76f6b9be872faa8dec7f170e6f546db4df928ded6abf6a3d9e2e1f0cd603a238b7e16a9921eedecef02a912eb8d8557ba7d409542c2f1164d1b5ec70208baf254c0d15e1238af04d79532826ddb3449f118e361924706b5a2e49f90e279281513585cae65d28e9019e42d69ff0d872fd4ed368fdfd53ccf662b781fa4fd287d548722d8db7d869361fb8db577df8e78cf73b26c41dc4587a8cc7c5469a6ba0cd21b83cc2db1292235e96425b764037ceed3a81c41fcc32ff00d28d38b90756916f329267ded7dda386a398282da9ed6c9efd8103f2bed95c679683d557b612ebf636a2137693ee869f2cbf843a892c09f5e64eee67e4a6f5a08be601c9c72b93ee307dfcef1ff0a49da20720346ff279a1dbe87c2a9b7be7bd1e9e4b144921ed59366a72dcd1d189ad370a1f57b2ed9dc736ff0008b4afb847922da16d0ead3c0ee4180a6c5a322cfdfa1fa2af8dfb2e0f1e7e6af2abb6c208b11911c0859bbd8d94e87256d024f8fc16dfa3945d540643df9721c980e64f8916f2772b65700a0eba60d3934769eef758def1f95b89206f5b99260e390b3400d6b7dd60166b79643e6929ef868fc78d7a02a182d97c564b148f6270eb64fec95b3d9543d28a6da8cb86ad21c3eab91a39a764c7d5c3b0f239e5e0ba05351f574b4ae0327457cb8b897bcf9dda3c963aba3eb236c83502c7c968ba398975b032127fc4841d91ef32f7cb98bdbd12b58ffd181fc1abe85550fc643959db60788371f55dbe67d82e09840d87b66bdbab7824e9a1ddc976fafac6ec020ea2fe4a5c9899c9b686d3d4bcbb3b72b22e20e3b06d9140a19daeb1baf62158c68b12a1be0f13842c3c3b6c826e55af517d554d254376c9beaad0d50b5eeba7304ae3da398fb4ec2dbd5b9e3f2e6b23d0ee8afe24ed3f260f8ad4fb4cc61a5bd534dcb88bf20adfa06d68a61a73569a73c63295b858e1980985a040e2c68dda85e5a3a5a861160e09147e4a7801a9b214ad419ca20323d3dc4fab8c460f6a5b8cb50c1de3f20b99b9f979fc069f55a0e99c85d5925cdec1ad1c86c8361e649f359b9b7782d5c53889d31a5c9ee702109c8719cd6944cb489e081e0145aea6db1a805b9b4e62c7ef726d2486c51db9e5c5cd07c0dae8b152c62452136da02e5b9e59070162df3b03cf2e4a4c67350e139679ed175fcddf4da3ea8913ecd077d92af86162e2709c9c371dc894f2b4b6c7347d8db00936b8d05ad95b95f7a8b0538b817399b6b6e3fc25dfec62354d2756769b9b4fc1399268ac1d0767befd38dc6fdc7c1554fd9246be3fd59327a0171888802503f4bfe8efa2cb558cefc56bd8f2585a73041d5646ac64791212bf809afe8fc5d553b6e3b5504bb9f54c25ad006e05db46fbf646ed6e21190fbbd95754767a968d1b0c007fb013f12559c03b3e05ca7f5bfd9a782b2f031cc5d44ad8f69a42910e69b3fc97236bf8315860b3a485dc4dbe8a0491ba3776490e69bb48d47829b5aed9aab8df6523148c6d03c53b5a7994b1e17f8162bf8a68dab07305e4601dfdc1ed039e442e914158e3131ae39b46c9f11a85c4fa37318eaa22d36ff1367fd2e1621757a1168c79fcd67b9fa06e7a5e36bb6742428d5357b5bd57bca03ca9feb3bbb1f5358e07271f54c7e292116db77a955f547351d8e2abd1603b7a55e2cc2f75cf156786d69632c0d947aa68b2ac91c5514eac0e97a7177e81e7d57967768af2efd681a7ffd9, '123456789', 'diogo.anastacio.30473@esgc.pt', '962187271', '', 1, 0, 1),
(19, 'admintest', ' admin', '2024-05-20', NULL, '', '$2y$10$DCfsxIL.obfLy/CPRdnPjuGOJ7DieQCpOQBVGrx5x4mvMb2q./YXy', 'admin@gmail.com', '1234567890', '0', 1, 0, 1),
(22, 'usertest', ' user', '2024-05-20', NULL, '', '$2y$10$AIl5z6lRPGhRioHnc6i4yOh1Psx4H31Qr02J6k2HyuCQu8Gx9TwDi', 'user@gmail.com', '0987654321', '0', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `recover`
--

CREATE TABLE `recover` (
  `recover_id` int(11) NOT NULL,
  `user` varchar(55) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recover`
--

INSERT INTO `recover` (`recover_id`, `user`, `email`, `phone`, `Description`, `status`) VALUES
(1, 'john_doe', 'john.doe@example.com', '1234567890', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_department`
--

CREATE TABLE `roles_department` (
  `roles_department_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(55) NOT NULL,
  `space` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_name`, `space`, `description`) VALUES
(1, 'Meeting Room 1', 20, 'Conference room for team meetings'),
(5, 'Meeting Room 2', 30, 'Large conference room'),
(21, 'meeting', 2, 'sadas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD PRIMARY KEY (`bookmark_id`),
  ADD KEY `user` (`people_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `building_offices`
--
ALTER TABLE `building_offices`
  ADD PRIMARY KEY (`building_id`,`office_id`),
  ADD KEY `building_id` (`building_id`),
  ADD KEY `office_id` (`office_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD UNIQUE KEY `department` (`department`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`office_id`);

--
-- Indexes for table `offices_room`
--
ALTER TABLE `offices_room`
  ADD PRIMARY KEY (`office_id`,`room_id`),
  ADD KEY `office_id` (`office_id`,`room_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`people_id`),
  ADD UNIQUE KEY `user` (`user`),
  ADD UNIQUE KEY `user_2` (`user`),
  ADD KEY `department_id` (`role_department_id`);

--
-- Indexes for table `recover`
--
ALTER TABLE `recover`
  ADD PRIMARY KEY (`recover_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_2` (`role`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `roles_department`
--
ALTER TABLE `roles_department`
  ADD PRIMARY KEY (`roles_department_id`),
  ADD UNIQUE KEY `department_id` (`department_id`,`role_id`),
  ADD KEY `roles_department_Roles_FK_1` (`role_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmark`
--
ALTER TABLE `bookmark`
  MODIFY `bookmark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `people_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `recover`
--
ALTER TABLE `recover`
  MODIFY `recover_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles_department`
--
ALTER TABLE `roles_department`
  MODIFY `roles_department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmark`
--
ALTER TABLE `bookmark`
  ADD CONSTRAINT `Bookmark_Offices_room_FK_1` FOREIGN KEY (`room_id`) REFERENCES `offices_room` (`room_id`),
  ADD CONSTRAINT `Bookmark_People_FK_2` FOREIGN KEY (`people_id`) REFERENCES `people` (`people_id`);

--
-- Constraints for table `building_offices`
--
ALTER TABLE `building_offices`
  ADD CONSTRAINT `Building_offices_Building_FK` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`),
  ADD CONSTRAINT `Building_offices_Offices_FK` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`);

--
-- Constraints for table `offices_room`
--
ALTER TABLE `offices_room`
  ADD CONSTRAINT `Offices_room_Oficces_FK` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`),
  ADD CONSTRAINT `Offices_room_Room_FK` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`);

--
-- Constraints for table `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `people_Role_department_FK_1` FOREIGN KEY (`role_department_id`) REFERENCES `roles_department` (`roles_department_id`);

--
-- Constraints for table `roles_department`
--
ALTER TABLE `roles_department`
  ADD CONSTRAINT `roles_department_Department_FK_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `roles_department_Roles_FK_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `inactive_expired_bookmarks` ON SCHEDULE EVERY 1 DAY STARTS '2024-03-05 15:03:59' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Inactive expired bookmarks every day' DO UPDATE bookmark 
    SET active = 0 
    WHERE selected_date < CURDATE() AND end_hour < CURTIME()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
