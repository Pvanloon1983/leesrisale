<?php
 session_start();
 include_once('config/db.php');
 $booktitle = "Het Traktaat over de Natuur";
 $bookUrlPHP = "/het-traktaat-over-de-natuur";
 include('includes/header-book-page.php'); 
?>

  <div class="sidebar">
    <span class="inhoudsopgave-toggle ">
      <span class="sluiten"><i class="fa-solid fa-xmark"></i></span>
    </span>
    <ul>
      <li class="text-inhoudsopgave">Inhoudsopgave</li>
      <li class="item"><a href="#5">Voorwoord</a></li>
      <li class="item"><a href="#9">De Drieëntwintigste Flits</a></li>
      <li class="item"><a href="#9">Waarschuwing</a></li>
      <li class="item"><a href="#13">Inleiding</a></li>
      <li class="item"><a href="#14">De eerste kwestie</a></li>
      <li class="item inspring"><a href="#14">De eerste onmogelijkheid</a></li>
      <li class="item inspring"><a href="#16">De tweede onmogelijkheid</a></li>
      <li class="item inspring"><a href="#17">De derde onmogelijkheid</a></li>
      <li class="item"><a href="#18">De tweede kwestie</a></li>
      <li class="item inspring"><a href="#18">De eerste onmogelijkheid</a></li>
      <li class="item inspring"><a href="#20">De tweede onmogelijkheid</a></li>
      <li class="item inspring"><a href="#21">De derde onmogelijkheid</a></li>
      <li class="item"><a href="#22">De derde kwestie</a></li>
      <li class="item inspring"><a href="#22">De eerste onmogelijkheid</a></li>
      <li class="item inspring"><a href="#23">De tweede onmogelijkheid</a></li>
      <li class="item inspring"><a href="#28">De derde onmogelijkheid</a></li>
      <li class="item"><a href="#41">Slot</a></li>
      <li class="item inspring"><a href="#41">De eerste vraag</a></li>
      <li class="item inspring"><a href="#44">De tweede vraag</a></li>
      <li class="item inspring"><a href="#49">De derde vraag</a></li>
    </ul>
  </div>

  <?php
  // Check if the user is logged in using session or remember me cookie
  if (isset($_SESSION['user_id'])) {
      // User is logged in via session
      echo '
      
      <div class="sidebar-right">
      <span class="inhoudsopgave-toggle-right">
        <span class="sluiten-right"><i class="fa-solid fa-xmark"></i></span>
      </span>
      <p class="title-sidebar-right">Bladwijzers</p>
      <button class="add-book-mark-button">Voeg een bladwijzer toe <i class="fa-solid fa-plus"></i></button>
      <ul>      
        <!-- The empty bookmark item is removed from the HTML -->
      </ul>
      </div>
      
      ';
  } elseif (isset($_COOKIE['remember_token']) && !empty($_COOKIE['remember_token'])) {
      $token = $_COOKIE['remember_token'];

      // Retrieve user from the database based on the remember token
      $stmt = $conn->prepare("SELECT * FROM users WHERE remember_token = :token");
      $stmt->bindParam(':token', $token);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user) {
          // User is logged in via remember me cookie
          $_SESSION['user_id'] = $user['id'];
          echo '
          
          <div class="sidebar-right">
          <span class="inhoudsopgave-toggle-right">
            <span class="sluiten-right"><i class="fa-solid fa-xmark"></i></span>
          </span>
          <p class="title-sidebar-right">Bladwijzers</p>
          <button class="add-book-mark-button">Voeg een bladwijzer toe <i class="fa-solid fa-plus"></i></button>
          <ul>      
            <!-- The empty bookmark item is removed from the HTML -->
          </ul>
          </div>
          
          ';
      } else {
          echo '
          
          <div class="sidebar-right">
          <span class="inhoudsopgave-toggle-right">
            <span class="sluiten-right"><i class="fa-solid fa-xmark"></i></span>
          </span>
          <p class="title-sidebar-right">Bladwijzers</p>
          <button class="add-book-mark-button">Voeg een bladwijzer toe <i class="fa-solid fa-plus"></i></button>
          <ul>      
            <!-- The empty bookmark item is removed from the HTML -->
          </ul>
          </div>
          
          ';
      }
  } else {
      echo '
      
      <div class="sidebar-right">
      <span class="inhoudsopgave-toggle-right">
        <span class="sluiten-right"><i class="fa-solid fa-xmark"></i></span>
      </span>
      <p class="title-sidebar-right">Bladwijzers</p>
      <button class="add-book-mark-button add-book-mark-button-server">Voeg een bladwijzer toe <i class="fa-solid fa-plus"></i></button>
      <ul>      
        <!-- The empty bookmark item is removed from the HTML -->
      </ul>
      </div>
      
      ';
  }
  ?>


  <div class="config-page-bottom">
    <div class="config-page-bottom-container">
      <div>
        <div class="config-page-right-options">
          <i class="fa-solid fa-arrow-up top go-to-top-page"></i>  
          <span class="icon-letter-size">Aa </span>
          <button class="size-min size-button"><i class="fa-solid fa-minus"></i></button>
          <button class="size-plus size-button"><i class="fa-solid fa-plus"></i></button>       
          <button class="reset-font-sizes"><i class="fa-solid fa-arrow-rotate-left"></i></button>       
        </div>
      </div>
      <div class="config-page-left-options">
        <span class="blz-select-text">Blz. </span><select class="blz-select" name="bladzijdes" id="bladzijdes-select">
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
          <option value="32">32</option>
          <option value="33">33</option>
          <option value="34">34</option>
          <option value="35">35</option>
          <option value="36">36</option>
          <option value="37">37</option>
          <option value="38">38</option>
          <option value="39">39</option>
          <option value="40">40</option>
          <option value="41">41</option>
          <option value="42">42</option>
          <option value="43">43</option>
          <option value="44">44</option>
          <option value="45">45</option>
          <option value="46">46</option>
          <option value="47">47</option>
          <option value="48">48</option>
          <option value="49">49</option>
          <option value="50">50</option>
          <option value="51">51</option>
          <option value="52">52</option>
        </select> 
        
        <ul class="menu">
          <?php
          // Check if the user is logged in using session or remember me cookie
          if (isset($_SESSION['user_id'])) {
              // User is logged in via session
              echo '<li><a href="logout"><i class="fa-solid fa-right-from-bracket"></i></a></li>';
          } elseif (isset($_COOKIE['remember_token']) && !empty($_COOKIE['remember_token'])) {
              $token = $_COOKIE['remember_token'];

              // Retrieve user from the database based on the remember token
              $stmt = $conn->prepare("SELECT * FROM users WHERE remember_token = :token");
              $stmt->bindParam(':token', $token);
              $stmt->execute();
              $user = $stmt->fetch(PDO::FETCH_ASSOC);

              if ($user) {
                  // User is logged in via remember me cookie
                  $_SESSION['user_id'] = $user['id'];
                  echo '<li><a href="logout"><i class="fa-solid fa-right-from-bracket"></i></a></li>';
              } else {
                  echo '<li><a href="inloggen"><i class="fa-solid fa-user"></i></a></li>';
              }
          } else {
              echo '<li><a href="inloggen"><i class="fa-solid fa-user"></i></a></li>';
          }
          ?>
      </ul>
      </div> 
    </div>
  </div>

  <div class="pagina-container boek-pagina-page">

    <div class="text-center pagina-title-reeks">
      <p>Uit de Reeks van de Risale-i Nur</p>
      <h1>Het Traktaat over De Natuur</h1>
      <p>Bedîüzzaman Said Nursî</p>
    </div>

    <div class="pagenumber" id="5">
      <h3 class="text-center">Voorwoord</h3>
      <p>De Risale-i Nur is een boekenreeks die geschreven is door de Islamitische geleerde Said Nursî <img src="svg_honorifics/ra-1-removebg.svg" style="width: 25px;margin-left: -3px;">. Deze boekenreeks bestaat uit twaalf boeken, waaronder: de Woorden (bestaande uit 33 woorden), de Brieven (bestaande uit 33 brieven), de Flitsen (bestaande uit 33 flitsen) en de Lichtstralen (bestaande uit 15 lichtstralen). In elk van deze 33 woorden, brieven, flitsen en 15 lichtstralen wordt een religieus onderwerp uiteengezet.</p>

      <p>Dit is een poging om ‘de Drieëntwintigste Flits' uit de reeks van de Risale-i Nur te vertalen. Wij hebben ons best gedaan om ons zoveel mogelijk te houden aan de stijl die gebruikt wordt in het originele exemplaar. We hebben daarbij niet alleen rekening gehouden met taalkundige aspecten, maar ook met het vloeiende karakter van de brontekst. Mochten er onduidelijkheden of fouten in de vertaling voorkomen, dan is dat te wijten aan de gebreken van de vertalers. Enkele gedeeltes kunnen ingewikkeld overkomen. Echter, naarmate men het vaker leest, zal met Gods verlof de boodschap helder worden.</p>

      <p>Dit boek is vertaald door een non-profitorganisatie. Daarom vragen wij de lezers om smeekbeden te verrichten voor de vertalers en de leden van de organisatie, opdat wij in de toekomst meer en betere vertalingen mogen leveren.</p>

      <p class="text-end blz-num">5</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="6">
      <p>Moge ALLAH dit traktaat vele diensten doen verlenen en de vertalers, de broeders die een bijdrage hebben geleverd aan de vertaling, de lezers, de Nurstudenten en de volgelingen van Mohammed <img src="svg_honorifics/saw-1-removebg.svg" style="width: 15px;margin-left: -3px;"> vergeven en zegenen.</p>

      <p>Mogen onze meester Mohammed <img src="svg_honorifics/saw-1-removebg.svg" style="width: 15px;margin-left: -3px;"> zijn afstammelingen en zijn metgezellen zoveel vrede en zegeningen ontvangen als het aantal letters van dit boek, als het aantal sterren in de hemelen en als het aantal atomen in het bestaan. Amîn, amîn, amîn.</p>

      <p class="text-end text-italic">De Vertalers</p>

      <p class="text-end blz-num">6</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="9">
      <h3 class="text-center">De Drieëntwintigste Flits</h3>

      <p>Hoewel dit traktaat de Zestiende Notatie van de Zeventiende Flits hoorde te zijn, is het vanwege zijn belang de Drieëntwintigste Flits geworden. Deze flits doodt de vanuit de natuur geïnspireerde, atheïstische argumentatie en sluit iedere mogelijkheid tot wedergeboorte uit. Aldus wordt de grondslag van ongeloof met de grond gelijk gemaakt.</p>

      <p class="text-bold">Waarschuwing</p>

      <p>In deze notatie wordt met negen onmogelijkheden, waarin er in elk minstens negentig onmogelijkheden voorkomen, uiteengezet hoe ver van het verstand verwijderd, hoe lelijk en hoe onrealistisch het ware gezicht is van het pad dat de verloochenaars onder de naturalisten bewandelen. Omdat die onmogelijkheden deels worden omschreven in diverse traktaten, zijn hier vanwege de aangehouden bondige stijl enkele treden overgeslagen. Dankzij deze stijl kan gedurende het lezen plotseling de volgende gedachte te binnen schieten: “Hoe kunnen deze roemrijke en intelligente filosofen een dergelijk klaarblijkelijke en heldere onmogelijkheid aannemen en dat pad aanhouden?"</p>

      <p class="text-end blz-num">9</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="10">
      <p>Waarlijk, zij waren niet in staat om het ware gezicht van hun weg te zien. Het ware gezicht van hun weg bestaat uit onredelijkheden die tevens de voorwaarden en vereisten zijn van hun weg. Ik ben bereid om aan twijfelaars met onbetwistbare bewijzen tot in detail uiteen te zetten en aan te tonen, dat zowel de samenvatting van hun weg als de voorwaarden en essentiële onmisbaarheden van hun weg, bestaan uit de lelijke en misselijke onredelijkheden<sup class="text-underline sup-pointer" title="De reden achter het schrijven van dit traktaat is de zeer buitensporige en erg lelijke wijze waarop atheïsten de Qur'an aanvallen en atheïsme associëren met de natuur door de geloofswaarheden te bespotten en hetgeen onbereikbaar is voor hun bedorven verstand te bestempelen als bijgeloof. Die aanval boezemde het hart felle furie in waardoor de pen flinke en forse klappen toebracht aan die atheïsten en aanhangers van valse wegen die zich afwenden van de waarheid. Anderzijds is de weg van de Risale-i Nur normaliter schoon, elegant en hoffelijk.">1</sup> die aan het eind van elke onmogelijkheid worden uiteengezet.</p>

      <hr class="hr-voetnoot">

      <p class="voetnoot-p"><sup>1 </sup>De reden achter het schrijven van dit traktaat is de zeer buitensporige en erg lelijke wijze waarop atheïsten de Qur'an aanvallen en atheïsme associëren met de natuur door de geloofswaarheden te bespotten en hetgeen onbereikbaar is voor hun bedorven verstand te bestempelen als bijgeloof. Die aanval boezemde het hart felle furie in waardoor de pen flinke en forse klappen toebracht aan die atheïsten en aanhangers van valse wegen die zich afwenden van de waarheid. Anderzijds is de weg van de Risale-i Nur normaliter schoon, elegant en hoffelijk.</p>

      <p class="text-end blz-num">10</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="11">
      <p class="text-center text-arabic"><sup class="text-underline sup-pointer" title="In de naam van ALLAH, de Barmhartige, de Genadevolle.">2</sup> بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحٖيمِ</p>
      <p class="text-center text-arabic"><sup class="text-underline sup-pointer" title="Hun profeten zeiden: bestaat er een twijfel aangaande ALLAH, Die de hemelen en aarde heeft voortgebracht? - De Heilige Qur'an, 14:10">3</sup> قَالَتْ رُسُلُهُمْ اَفِى اللّٰهِ شَكٌّ فَاطِرِ السَّمٰوَاتِ وَالْاَرْضِ</p>

      <p>Met een vraag in ontkennende vorm zegt dit verheven vers: “Er bestaat geen twijfel aangaande ALLAH en die hoort er ook niet te zijn", en duidt Gods bestaan en eenheid op een heldere wijze.</p>

      <p class="text-italic">Een herinnering voorafgaand aan de beschrijving van dit geheim: in 1338 <sup class="text-underline sup-pointer" title="Noot van de vertalers: dit is het jaartal volgens de Islamitische jaartelling. Volgens de Christelijke jaartelling was dit het jaar 1922.">4</sup> bezocht ik Ankara. Ik zag dat er misleidend geopereerd werd aan de implantatie van een zeer akelige atheïstische gedachtegang om de krachtige denkpatronen van het gelovige volk te verstoren en te vergiftigen, welk destijds in blijde verkeerde wegens de triomf van het Islamitische leger op de Grieken. Ik zei: “God verhoede, deze serpent zal de fundamenten van het geloof bestoken!" Vanuit het perspectief van Gods bestaan en een-</p>

      <hr class="hr-voetnoot">

      <p class="voetnoot-p"><sup>2 </sup>"In de naam van ALLAH, de Barmhartige, de Genadevolle."</p>
      <p class="voetnoot-p"><sup>3 </sup>"Hun profeten zeiden: bestaat er een twijfel aangaande ALLAH, Die de hemelen en aarde heeft voortgebracht?" - De Heilige Qur'an, 14:10</p>
      <p class="voetnoot-p"><sup>4 </sup>Noot van de vertalers: dit is het jaartal volgens de Islamitische jaartelling. Volgens de Christelijke jaartelling was dit het jaar 1922.</p>

      <p class="text-end blz-num">11</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="12">
      <p>heid raadpleegde ik dat vers, en schreef in het Arabisch een uit de Qur'an geïnspireerd bewijsstuk dat krachtig genoeg was om de essentie van die atheïsten overhoop te halen. Ik had het laten drukken door de drukkerij Yeni Gűn in Ankara. Echter, mede door een schaarse Arabisch beheersende populatie en een gebrek aan belangstelling, heeft dat zeer bondig samengevatte bewijsstuk zijn effect helaas niet kunnen tonen. Helaas is die atheïstische gedachtegang zowel gegroeid als geïntensiveerd. Noodgedwongen zal ik dat bewijsstuk deels in het Turks uiteenzetten. Omdat bepaalde onderdelen van dat bewijsstuk in diverse traktaten volledig zijn omschreven, zullen die hier in een beknopte vorm worden opgesteld. Verscheidene bewijzen die verdeeld zijn over diverse traktaten, verenigen zich deels in dit bewijsstuk. Een elk van die bewijzen dient als een deel van dit bewijsstuk.</p>      

      <p class="text-end blz-num">12</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="13">
      <h3 class="text-center">Inleiding</h3>   
      
      <p>O mens! Besef dat mensen riskante uitspraken doen die neigen naar ongeloof; onbewust citeren gelovigen dergelijke uitspraken. We zullen de drie voornaamste onder die uitspraken uiteenzetten:</p>

      <p><span class="text-italic">De eerste:</span> "Oorzaken creëren creaturen."</p>

      <p><span class="text-italic">De tweede::</span> "Creaturen ontstaan uit zichzelf, komen tot stand en vergaan."</p>

      <p><span class="text-italic">De derde:</span> "Een creatuur ontstaat natuurlijk, de natuur vergt en creëert het."</p>

      <p>Voorwaar, aangezien het bestaan existeert en niet verloochend kan worden, en ieder wezen op een kunstige en diepzinnige wijze vorm krijgt, en aangezien ieder wezen niet van oudsher bestaan heeft maar als iets nieuws tot stand komt, zul jij, atheïst zijnde, uiteraard beweren dat een wezen, bijvoorbeeld een dier, óf tot stand komt door wereldse oorzaken, oftewel vorm krijgt door een bundeling van oorzaken, óf dat het ontstaat uit zichzelf, óf dat het vorm krijgt door natuurlijke invloeden, omdat de natuur het vereist. Of het creatuur wordt gecreëerd met de macht van een Majestueuze Almachtige.</p>

      <p>Aangezien er rationeel gezien buiten deze vier wegen om geen andere wegen zijn, maakt het zonder twijfel of aarzeling de vierde weg – de weg van God-</p>

      <p class="text-end blz-num">13</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="14">
      <p>delijke eenheid – noodzakelijk en klaarblijkelijk definitief, wanneer absoluut bewezen wordt dat de overige drie wegen onmogelijk, fictief, uitgesloten en niet doenlijk zijn.</p>     
      
      <p><span class="text-italic text-bold">De eerste weg houdt in:</span> vorming van materie en ontstaan van schepselen middels samenkomst van kosmische oorzaken. We zullen slechts drie van de vele onmogelijkheden op deze weg specificeren.</p>

      <p class="text-bold">De eerste onmogelijkheid</p>

      <p>In een apotheek bevonden zich honderden flesjes en potjes gevuld met verschillende substanties. Er werd een levend mengsel gewenst van die middelen. Tevens was er behoefte aan een uitmuntend medicijn dat ook uit die middelen samengesteld moest worden en evenzeer leven hoorde te bezitten. We betraden die apotheek en zagen vele voorbeelden van dat levende mengsel en medicijn. We onderzochten elk van die mengsels.</p>

      <p>We ontdekten dat er uit ieder flesje en potje verschillende doseringen gebruikt werden met een specifieke proportie. Er werd een kleine dosis van het ene flesje, een andere dosis van het andere genomen, enzovoorts. Als er een minieme dosis meer of minder gebruikt werd, zou dat mengsel niet kunnen leven en zijn werking niet tonen. Ook hebben wij dat levende medicijn onderzocht. Uit elk potje werd een substantie gebruikt met een specifieke proportie. Als er een microscopische dosis tekortschoot of overschoot,</p>

      <p class="text-end blz-num">14</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="15">
      <p>verloor dat medicijn zijn effect. Hoewel er meer dan vijftig van die potjes waren, was er van elk een andere dosis genomen, alsof er met een aparte normering gedoseerd werd.</p>

      <p>Is er al met al ook maar een vorm van een mogelijkheid of kans dat die flesjes met diverse doseringen, door een vreemd toeval of door een storm, omkantelden waardoor exact de benodigde dosering eruit stroomde, samenkwam, ineensmolt en dat mengsel verscheen? Bestaat er iets onzinniger, onmogelijker en fictiever dan dit? Iemand die herhaaldelijk in waanzin verkeert en vervolgens tot bezinning komt, zal vluchten van een dergelijke bewering met de woorden: "Ik deel deze gedachtegang niet."</p>

      <p>Voorwaar, zoals dit voorbeeld aantoont, is uiteraard ieder organisme een levend mengsel. Daarbij dient iedere plant als een levend medicijn, die uit vele verschillende doseringen, diverse substanties en zeer delicate proporties gevormd wordt. Al dit toedichten aan oorzaken en elementen, met de bewering: "Oorzaken creëren creaturen", is net zo onmogelijk, fictief en ver van het verstand verwijderd als het ontstaan van het mengsel uit die apotheek door het omkantelen van de flesjes.</p>

      <p>Kortom, in deze fenomenale apotheek van het universum kunnen levende substanties, welke gebruikt worden naar de balans van het lot en besluit der Preeeuwige Alwijze, enkel existentie ondervinden bij de gratie van eindeloze wijsheid, onbegrensde kennis en</p>

      <p class="text-end blz-num">15</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="16">
      <p>een alomvattende wil. Een ellendeling die beweert: “Ontelbare blinde en dove elementen, natuurprocessen en oorzaken, welke razen zoals vloeden, verrichten dit werk” of een suffe bazelaar die raaskalt: “Dat vreemde mengsel vormde zichzelf na het omkantelen van de flesjes en kwam tot stand” is vele malen dwazer dan een dronken dwaas. Waarlijk, die heresie is niets meer dan dwaze, redeloze en suffe lariekoek.</p>
        
        <p class="text-bold">De tweede onmogelijkheid</p>

        <p>Als alles niet wordt geattribueerd aan de Majestueuze Almachtige, Die de Ene Individuele is, maar aan oorzaken wordt toegedicht, dan is de interventie van vele kosmische elementen en oorzaken voor de vorming van ieder schepsel een vereiste. Daarentegen is de samenkomst van diverse contraire en botsende oorzaken met een volmaakte ordening, zeer delicate normering en complete saamhorigheid in het lichaam van een minuscuul schepsel zoals een vlieg, een dusdanig evidente onmogelijkheid, dat iemand met zoveel besef als de vleugel van een vlieg nog zou bekennen dat dit onmogelijk is.</p>

        <p>Waarlijk, het minuscule lichaam van een vlieg is betrokken bij de meeste elementen en oorzaken van het universum; het is er zelfs een index van. Als dit niet wordt geattribueerd aan de Pre-eeuwige Almachtige, dan horen die materiële oorzaken hoogstpersoonlijk present te zijn gedurende haar vorming – die horen bovendien in haar minuscule lichaam te treden. Die horen zelfs in een cel van haar oog te treden, welke</p>

      <p class="text-end blz-num">16</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="17">
      <p>een klein exemplaar is van haar lichaam, want als de oorzaak materieel is, hoort die zich in het bijzijn van en binnenin het resultaat te bevinden. In een dergelijk geval hoort men aan te nemen dat kosmische basiselementen, bouwstoffen en natuurprocessen zich fysiek in die cel bevinden, waar niet eens de pootjes van twee vliegen ter grootte van een naald in passen, en daarbinnen als specialisten opereren. Voorwaar, zelfs de meest dwaze sofisten schamen zich voor een dergelijke weg.</p>

      <p class="text-bold">De derde onmogelijkheid</p>

      <p><span class="text-arabic">اَلْوَاحِدُ لَا يَصْدُرُ اِلَّا عَنِ الْوَاحِدِ</span> oftewel zoals de vastgestelde, norm luidt: “Als er eenheid is in een wezen, kan die uiteraard uitsluitend door één eenheid, uit één hand ontstaan.” Met name wanneer dat wezen in een zeer buitengewone ordening en delicate normering verkeert en een omvangrijk leven bezit, toont het glashelder aan dat het niet is ontstaan uit verschillende handen, wat een reden is tot geschil en wanorde, maar ontstaan is uit één Hand van Iemand uitermate machtig en wijs. Een dusdanig ordelijk, uitgebalanceerd en harmonieus wezen alsnog toedichten aan handen van ontelbare, levenloze, onwetende, ordeloze, onbewuste, chaotische, blinde en dove natuurlijke oorzaken – terwijl de blindheid en doofheid van die oorzaken toenemen gedurende hun vereniging en bundeling binnen eindeloze mogelijkheden – is net zo ver van het verstand verwijderd als het op slag aanvaarden van honderd onmogelijkheden.</p>

      <p class="text-end blz-num">17</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="18">
      <p>Al wordt deze onmogelijkheid genegeerd, alsnog oefenen materiële oorzaken enkel invloed uit middels direct contact en binding. Natuurlijke oorzaken hebben echter enkel contact met het fysiek van levende wezens. Daarentegen zien wij dat de onzichtbare aspecten van die organismen, waar de handen van materiële oorzaken niet reiken, vele malen ordelijker, fraaier en qua kunst veel volmaakter zijn. De handen en instrumenten van materiële oorzaken komen in geen geval bij de immateriële aspecten van minuscule organismen en diertjes; zelfs volledig contact met hun fysiek is niet mogelijk. Hoewel dergelijke creaties qua kunst veel eigenaardiger en qua schepping veel fraaier zijn dan de grootste schepselen, is hen alsnog toedichten aan dove en blinde oorzaken, welke levenloos, onwetend, ruw, afstandelijk, omvangrijk en contrair zijn, slechts mogelijk door zelf honderdmaal blinder en duizendmaal dover te zijn.</p>

      <p><span class="text-italic text-bold">De tweede kwestie houdt in:</span> "Zelfvormend" oftewel "Het ontstaat uit zichzelf". Voorwaar, ook deze bewering bevat vele onmogelijkheden. Vanuit vele perspectieven is ze fictief en onmogelijk. Ter illustratie zullen we drie van de onmogelijkheden uiteenzetten.</p>

      <p class="text-bold">De eerste onmogelijkheid</p>

      <p>O stijfkoppige loochenaar! Jouw ego heeft jou dusdanig verdwaasd, dat jij als het ware honderd onmogelijkheden eensklaps aanvaardt; want jij bestaat – en jij bent geen simpele substantie, niet levenloos en ook niet stabiel. Jij lijkt op een constant vernieuwende,</p>

      <p class="text-end blz-num">18</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="19">
      <p>welgeordende machine en een voortdurend renoverend, voortreffelijk paleis. Ieder moment functioneren atomen in jouw lichaam. Jouw lichaam heeft, voornamelijk omtrent onderhoud en voortbestaan, een associatie en een ruilverkeer met het universum. De atomen die functioneren in jouw lichaam zien er op toe dat die verbondenheid niet wordt onderbroken en die associatie niet wordt verstoord, waarna ze uit voorzorg stappen ondernemen. Het lijkt alsof ze het hele heelal observeren, jouw bindingen met het heelal signaleren en naar aanleiding daarvan hun positie innemen. Vervolgens maak jij gebruik van die buitengewone positie met jouw externe en interne waarnemingen.</p>

      <p>Als jij weigert te aanvaarden dat de atomen in jouw lichaam minuscule functionarissen zijn, of een leger, of de uiteinden van de pen der beschikking (elk atoom dient als een uiteinde), of de punten uit de pen der macht (elk atoom dient als een punt), die handelen naar de wetten van de Pre-eeuwige Almachtige, dan dient het actieve atoom in jouw oog een oog te bezitten dat zowel jouw complete lichaam als heel het heelal waarbij jij betrokken bent in het zicht heeft. Tevens hoort hem een verstand van duizend genieën toegedicht te worden welk de bronnen van jouw gehele verleden, toekomst, generatie, oorsprong en elementen tezamen met de mineralen voor jouw onderhoud kent en herkent. Een wetenschap en inzicht van duizend Plato's toedichten aan het atoom van iemand zoals jij, die geen greintje verstand heeft van dergelijke kwesties, is een onmetelijk dwaas bijgeloof.</p>

      <p class="text-end blz-num">19</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="20">
      <p class="text-bold">De tweede onmogelijkheid</p>

      <p>Jouw lichaam lijkt op een prachtig paleis met duizend koepels waarvan elk is opgebouwd uit stenen die elkaar ondersteunen zonder steunpilaren. Jouw lichaam is zelfs duizendmaal merkwaardiger dan dit paleis, want jouw lichamelijke paleis wordt voortdurend gerenoveerd met volmaakte orde. Afgezien van de ziel, het hart en de spirituele zintuigen, welke in wezen uiterst bijzonder zijn, is elk orgaan van jouw lichaam als een vesting met een koepel. Door elkaar achtereenvolgens met een volmaakte normering en orde te ondersteunen, zoals de stenen in die koepels, stellen atomen een buitengewone constructie, een fenomenaal kunstwerk en een verbazingwekkend machtig mirakel ten toon, zoals het oog en de tong.</p>

      <p>Als deze atomen geen ambtenaren zouden zijn, onderhevig aan het bevel van de Bouwmeester der kosmos, dan zou ieder atoom ten opzichte van alle atomen in het lichaam én absolute heerser, én absolute onderdaan, én identiek, én contrair wat betreft gezag moeten zijn; tevens dient elk ervan de bron en oorsprong te zijn van de meeste attributen die enkel de Absoluut Existerende toebehoren. Hun capaciteiten zijn zowel zeer beperkt als veelomvattend. Voor iemand met het bewustzijn van een atoom is het toedichten van een zeer geordend uniek kunstwerk, welk volgens het eenheidsgeheim alleen het kunstwerk kan zijn van de Ene Individuele, duidelijk een zeer klaarblijkelijke onmogelijkheid die uit honderd onmogelijkheden bestaat.</p>

      <p class="text-end blz-num">20</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="21">
      <p class="text-bold">De derde onmogelijkheid</p>

      <p>Als jouw lichaam geen brief zou zijn, geschreven door de pen der Pre-eeuwige Almachtige, Die de Ene Individuele is, maar een afdruk van de natuur en oorzaken, dan zouden er, beginnend vanaf de vorm van één lichaamscel in jouw lijf, zoveel concentrische drukblokken als de duizenden aantallen componenten aanwezig moeten zijn. Want als bijvoorbeeld dit boek een brief zou zijn, zou één pen, berustend op de kennis van haar auteur, alles kunnen schrijven. Als het geen brief zou zijn, niet werd geattribueerd aan de pen van een auteur en er beweerd werd dat het uit zichzelf is ontstaan of aan de natuur zou worden toegedicht, dan is er, net zoals bij een gedrukt boek, behoefte aan een ijzeren pen voor elke geschreven letter, opdat het gedrukt kan worden.</p>

      <p>In een drukkerij behoren op voorhand zoveel drukletters aanwezig te zijn als het aantal benodigde letters. Daarna kunnen de letters pas tot stand komen. In die situatie is er, ter vervanging van één pen, behoefte aan evenveel pennen als het aantal toegepaste letters. Wanneer er tevens in die brief met een kleine pen binnen een grote letter een bladzijde met een fijn handschrift geschreven is, zoals soms het geval is, zijn er duizenden pennen nodig voor een enkele letter. Als ze zich daarenboven met elkaar combineren en op een geordende wijze een vorm aannemen – zoals in het geval van jouw lichaam – dan is er in elke kring, voor ieder onderdeel behoefte aan zoveel drukblokken als het aantal toegepaste componenten. Al zou je deze</p>

      <p class="text-end blz-num">21</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="22">
      <p>honderd vormen van onmogelijkheden mogelijk achten; als het maken van deze geordende kunstige drukletters, voortreffelijke drukblokken en pennen niet wordt geattribueerd aan één pen, is er voor het maken van die pennen, drukblokken en ijzeren drukletters alsnog behoefte aan wederom net zoveel pennen, drukblokken en letters, want ook die zijn gemaakt en ook die zijn kunstig geordend. Zo zou deze keten tot aan een eeuwigheid doorgestrekt kunnen worden.</p>

      <p>Voorwaar, besef ook dat dit een gedachtegang is die zich in net zoveel onmogelijkheden en verzinsels bevindt als het aantal atomen waar jij uit bestaat. O stijfkoppige loochenaar! Schaam je en zie af van deze dwaling.</p>

      <p><span class="text-italic text-bold">De derde uitspraak:</span> "De natuur vergt het, de natuur vormt het." Voorwaar, dit oordeel bevat vele onmogelijkheden. Ter illustratie zullen we er drie van specificeren.</p>

      <p class="text-bold">De eerste onmogelijkheid</p>

      <p>Als de visuele en diepzinnige kunst en vorming in het bestaan – die met name te zien zijn bij organismen – niet worden geattribueerd aan de pen der beschikking en macht van de Pre-eeuwige Zon, maar aan blinde, dove en gedachteloze natuur en energie worden toegedicht, dan behoort de natuur bij alles ontelbare figuurlijke machines en drukkerijen te vestigen, of in alles een macht en wijsheid te implanteren waarmee het heelal geschapen en beheerd kan wor-</p>

      <p class="text-end blz-num">22</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="23">
      <p>den. Bijvoorbeeld: de reflecties en weerkaatsingen van de zon zijn te zien in de atomen van glasstukken en druppels op het aardoppervlak. Als de reflecties van die miniatuurzonnetjes niet worden geattribueerd aan de enige zon in de hemel, is het noodzakelijk om aan te nemen dat er in ieder atoom van een glasstuk, waar geen uiteinde van een luciferstokje in past, een fysiek kleine maar inhoudelijk enorme, natuurlijke en ingeschapen zon gevestigd is die de attributen van de zon bezit. Wanneer wezens en organismen, zoals in het voorgaande voorbeeld, niet worden geattribueerd aan de reflecties van de namen der Pre-eeuwige Zon, hoort men aan te nemen dat er in ieder wezen, met name in ieder organisme, een natuur, een macht en zelfs een soort God aanwezig is die beschikt over een eindeloze macht en wilskracht en een onmetelijke wetenschap en wijsheid. Onder alle onmogelijkheden in het universum is een dergelijke redenering echter de meest fictieve en valse. Een mens die de kunst van de Schepper der kosmos toedicht aan een denkbeeldige, zinloze en onbewuste natuur, toont uiteraard aan dat hij honderdmaal dierlijker en onbewuster is dan dieren.</p>

      <p class="text-bold">De tweede onmogelijkheid</p>

      <p>Als de zeer geordende, evenwichtige, kunstige en diepzinnige wezens niet worden geattribueerd aan een onmetelijk machtige en ingenieuze Entiteit, maar aan de natuur worden toegedicht, dan behoort de natuur in ieder stukje aarde zoveel drukkerijen en machines in voorraad te hebben als de algehele hoeveelheid drukkerijen en fabrieken aanwezig in Europa, opdat dat</p>

      <p class="text-end blz-num">23</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="24">
      <p>stukje aarde de bron kan zijn voor de voeding en vorming van ontelbare bloemen en vruchten waar het de bakermat en kweekplaats van is. Want bij een schaal aarde, die voor bloemen als jardinière dient, is feitelijk te zien dat die de vaardigheid bezit om alle gezaaide bloemzaadjes – waarvan de vormen en structuren zeer verschillen van elkander – stuk voor stuk te formeren en modelleren. Als dit niet wordt geattribueerd aan de Majestueuze Almachtige, kan deze toestand niet geschieden wanneer er zich in die schaal met aarde geen immateriële, specifieke en natuurlijke machine bevindt voor elke bloem. Want zaadjes bestaan uit dezelfde substanties, evenals zygoten en eieren. Oftewel, ze bestaan uit een ordeloos, vormloos en deegachtig mengsel van waterstof, zuurstof, koolstof en stikstof. Bovendien zijn lucht, water, warmte en licht eveneens eenvoudig en onwillekeurig, en laten ze zich zoals vloeden door alles meevoeren. Daardoor vergen zowel de formatie van die ontelbare bloemen als de variërende, zeer ordelijke en kunstige wijze waarop ze ontspruiten uit die aarde op een klaarblijkelijke en noodgedwongen wijze de figuurlijke presentie van zoveel immateriële en minuscule drukkerijen en fabrieken in die schaal met aarde als aanwezig in Europa; opdat zoveel levende weefsels en duizenden verscheiden gebreide breisels geweven kunnen worden.</p>

      <p>Voorwaar, oordeel nu zelf hoezeer de atheïstische redeneringen van de naturalisten de grenzen van ratio overschrijden. Hoewel dwaze dronkaards in menselijke gedaantes die de natuur als vormer zien beweringen</p>

      <p class="text-end blz-num">24</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="25">
      <p>maken als: "Wij zijn intelligente wetenschappers!", kun je zien hoe ver ze verwijderd zijn van intelligentie en wetenschap en hoe ze zich een ondoenlijk bijgeloof, dat op geen enkele wijze mogelijk is, als weg kunnen toe-eigenen; lach er om en spuug er op.</p>

      <p><span class="text-italic">Mocht jij het volgende stellen:</span> als wezens worden toegedicht aan de natuur, ontstaan er dergelijke onverklaarbare onmogelijkheden. Het wordt dusdanig problematisch, dat die redenering wordt uitgesloten. Op wat voor wijze zou deze problematiek eigenlijk opgeheven worden wanneer alles aan de Ene Individuele Entiteit en Onafhankelijke wordt geattribueerd? En hoe zou die problematische onuitvoerbaarheid omslaan in een gangbare noodzakelijkheid?</p>

      <p><span class="text-italic">Het antwoord:</span> zoals vermeld in <span class="text-italic">de eerste onmogelijkheid:</span> hoewel de zegeningen en invloeden van zonneschijn middels de reflecties van miniatuurzonnetjes met absoluut gemak worden getoond – van een minuscuul atoom tot aan het oppervlak van de grootste oceaan – hoort men de aanwezigheid van een natuurlijke en fysieke verschijningsvorm van de zon in ieder atoom (wat een uitgesloten mogelijkheid is) mogelijk te achten wanneer de band met de zon wordt verbroken. Evenzo, als ieder wezen regelrecht geattribueerd wordt aan de Individuele en Onafhankelijke Entiteit, dan kan ieder wezen dankzij een band en een reflectie al zijn benodigdheden op een onvermijdelijk eenvoudige wijze aangereikt krijgen.</p>

      <p class="text-end blz-num">25</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="26">
      <p>Als die band wordt verbroken, die ambtenarij omslaat in wanorde en ieder wezen aan zichzelf en aan de natuur wordt overgelaten, hoort men aan te nemen dat de blinde natuur binnenin de zeer buitengewone lichamelijke machine van een organisme zoals een vlieg, die dient als een index van het heelal, bezitter is van een macht en wijsheid waarmee het heelal geschapen en beheerd kan worden. Dit is echter niet één onmogelijkheid; hierin bevinden zich duizenden onmogelijkheden.</p>

      <p>Zoals een gelijke of deelgenoot van de Absoluut Existerende Entiteit uitgesloten en onmogelijk is, is ook de externe interventie bij Zijn heerschappij en scheppingswijze zo uitgesloten en onmogelijk als de existentie van Zijn gelijke.</p>

      <p>Wat betreft de problematiek van de <span class="text-italic">tweede onmogelijkheid:</span> zoals bewezen in verscheidene traktaten, is de totstandkoming van één creatuur zo simpel en eenvoudig als de vorming van alle creaturen wanneer alles wordt geattribueerd aan de Ene Individuele. Als alles wordt toegedicht aan oorzaken en de natuur, wordt de totstandkoming van één iets zo problematisch als de vorming van alles; zoals bewezen in verscheidene traktaten met absolute bewijzen. Een samenvatting van een bewijs luidt als volgt:</p>

      <p>Als een man zich bindt met een sultan via krijgsdienst of dienaarschap, dan kan die dienaar of soldaat de oorzaak zijn van handelingen waarvoor een kracht vereist is welke zijn persoonlijke kracht honderddui-</p>

      <p class="text-end blz-num">26</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="27">
      <p>zend maal overtreft. Tevens is hij in staat om namens de sultan een grootvizier gevangen te nemen; want de benodigde accessoires en kracht voor de taken die hij verricht en werken die hij samenstelt, draagt hij niet zelf en hij is ook niet genoodzaakt die te dragen. Ten gevolge van die band worden die kracht en accessoires gedragen door de weelde van de sultan en zijn leger welk achter hem gepositioneerd is als steunpunt. Aldus lijken zijn verrichte handelingen op de fraaie handelingen van een sultan en kunnen de werken die hij tentoonstelt zo bijzonder zijn als de werken van een leger.</p>

      <p>Bijvoorbeeld, op basis van ambtenarij werd het paleis van de farao verwoest door een mier. Op basis van verbondenheid werd Nimrod vernietigd door een vlieg. En op basis van die band komen alle onderdelen van een enorme dennenboom tot volle wasdom vanuit een dennenpit ter grootte van een graankorrel<sup class="text-underline sup-pointer" title="Waarlijk, vanwege die band ontvangt die pit een bevel vanuit het Goddelijke lot en wordt aangewezen voor die voortreffelijke taken. Wanneer die band verbroken wordt, is er voor de vorming van die pit behoefte aan meer accessoires, macht en kunst dan nodig voor de vorming van die enorme dennenboom. Want alle materie en onderdelen in het fysiek van een dennenboom op de bergen, wier wezen een machtsvertoon is, horen in de immateriële dennenboom, welke de pit is wiens wezen het lot beduidt, gevestigd te zijn. Want de fabriek van die enorme boom is die pit. De voorbeschikte boom in die pit ontkiemt door middel van macht en bloeit uit tot een fysieke dennenboom.">5</sup>.</p>

      <p>Als die band wordt verbroken en die ambtenarij wordt beëindigd, dan is dat pitje genoodzaakt om de</p>

      <hr class="hr-voetnoot">

      <p class="voetnoot-p"><sup>5 </sup>Waarlijk, vanwege die band ontvangt die pit een bevel vanuit het Goddelijke lot en wordt aangewezen voor die voortreffelijke taken. Wanneer die band verbroken wordt, is er voor de vorming van die pit behoefte aan meer accessoires, macht en kunst dan nodig voor de vorming van die enorme dennenboom. Want alle materie en onderdelen in het fysiek van een dennenboom op de bergen, wier wezen een machtsvertoon is, horen in de immateriële dennenboom, welke de pit is wiens wezen het lot beduidt, gevestigd te zijn. Want de fabriek van die enorme boom is die pit. De voorbeschikte boom in die pit ontkiemt door middel van macht en bloeit uit tot een fysieke dennenboom.</p>

      <p class="text-end blz-num">27</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="28">
      <p>benodigde accessoires en kracht op eigen houtje te dragen. Op dat moment kan het slechts handelen naar de hoeveelheid kracht en krijgsuitrusting aanwezig in zijn minuscule bouw. Als de handelingen die hij in zijn voorgaande staat met gemak verrichtte, nu van hem gevraagd zouden worden, zou zijn miezerige wezen uitgerust moeten worden met de kracht van een leger en een fabriek die de benodigde oorlogsaccessoires van een sultan produceert. Waarlijk, zelfs komedianten die de onzinnigste bijgeloven en verhalen verzinnen om anderen tot lachen te brengen, zouden zich schamen voor deze fantasie.</p>

      <p>Tot slot: in het attribueren van ieder wezen aan de Absoluut Existerende bevindt zich een onvermijdelijke eenvoud. Vorming toedichten aan de natuur is daarentegen ondoenlijk problematisch en valt buiten de grenzen van ratio.</p>

      <p class="text-bold">De derde onmogelijkheid</p>

      <p>Hier volgen twee in diverse traktaten uiteengezette voorbeelden die deze onmogelijkheid beschrijven.</p>

      <p>Het eerste voorbeeld</p>

      <p>Een paleis dat in een afgelegen woestijn was gevestigd en met de modernste vindingen was verfijnd en gedecoreerd, werd eens betreden door een zeer primitieve man. Hij bezichtigde het paleis van binnen en zag duizenden kunstig geordende creaturen. Vanwege zijn primitiviteit begon hij zich het volgende in te beelden: “Zonder externe invloed heeft één van die</p>
        
      <p class="text-end blz-num">28</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="29">
      <p>creaturen in dat paleis het paleis met al wat zich er in bevindt gecreëerd.” Maar naar welk creatuur hij zich ook wendde, hij kon zelfs met zijn primitieve verstand geen creatuur vinden waaraan hij de creatie kon toedichten. Op den duur trof hij een schrift aan waarin het bouwplan, het burgerregister en de wetgeving van het paleis stonden opgesteld. Echter, evenals de overige creaturen bezat dat schrift geen macht, visie, gereedschap of wat voor vaardigheid dan ook om dat paleis te kunnen bouwen en decoreren. Desalniettemin, omdat hij in dat schrift – in tegenstelling tot in de overige creaturen – een universele binding zag aan de hand van wetenschappelijke wetten, zei hij, gedwongen door zijn radeloosheid, het volgende: "Voorwaar, dit schrift is de oorzaak van zowel de constructie, ordening en decoratie van dat paleis, als de vorming, verspreiding en positionering van die creaturen." Zodoende leidde zijn primitiviteit hem naar het gebazel van dwazen en dronkaards.</p>

      <p>Voorwaar, evenals in dit voorbeeld betrad een primitieve voorstander van de naar Godloochening leidende, naturalistische gedachtegang dit paleis van het bestaan, dat eindeloze malen ordelijker en volmaakter is dan het paleis uit het voorbeeld en omringd is met miraculeuze wijsheden. Zonder zich te realiseren dat dit een kunstige creatie van de Absoluut Existerende Entiteit zou kunnen zijn, Die niet beperkt is tot de grenzen der schepping, wendde hij zich van Hem af en ontdekte binnen de geschapen grenzen Gods universele natuurwetten en het kunstregister des Heren</p>
        
      <p class="text-end blz-num">29</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="30">
      <p>waaraan de zeer misplaatste en ongegronde benaming "natuur" gegeven wordt; deze dienen als het tableau van Gods beschikking waarop geschreven en gewist wordt en als een schrift dat verandering en vervorming ondergaat gedurende manifestaties van Gods macht in natuurprocessen. Tevens zei hij: “Deze creaturen behoeven klaarblijkelijk een oorzaak. Niets lijkt meer betrokken met het bestaan dan dit schrift. Al zou geen verstand accepteren dat dit schrift het werk vervult van een absolute soeverein en als bron dient voor vorming waar een eindeloze macht voor vereist is, zal ik alsnog zeggen dat dit schrift alles gecreëerd heeft, aangezien ik de Kunstenaar zonder oorsprong niet erken.” Wij zeggen daarop het volgende:</p>

      <p>O door de meest dwaze dwazen onderwezen dronken dwaas! Haal je hoofd uit het moeras van de natuur en kijk om je heen. Aanschouw een Majestueuze Kunstenaar Die in verschillende talen erkend en met verscheidene gebaren – van atomen tot aan planeten – aangeduid wordt. En aanschouw de reflecties van de Pre-eeuwige Wever, Die dat paleis gecreëerd en dat schrift geschreven heeft. Bezie Zijn wens, geef gehoor aan Zijn Qur'an en word bevrijd van dat gebazel.</p>

      <p class="text-bold">Het tweede voorbeeld</p>

      <p>Eens betrad een zeer primitieve man een opzienbarend legerkamp en observeerde de samenscholing en geordende handelingen van een volkomen gedisciplineerd leger. Hij zag dat een bataljon, legioen en divisie met het sein van een soldaat opstond, halt hield,</p>
        
      <p class="text-end blz-num">30</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="31">
      <p>marcheerde en op commando vuurde. Zijn woeste en primitieve verstand kon een commandant die beveelt en commandeert naar de regelgeving van een land en de wetten van een sultan niet bevatten, dus verloochende hij hem. Vervolgens beeldde hij zich in dat die soldaten door koorden met elkaar verbonden waren. Hij filosofeerde over dat denkbeeldige buitengewone koord en stond perplex.</p>

      <p>Vervolgens vertrok hij en bezocht op een vrijdag een moskee, zo indrukwekkend als de Aya Sofia. Hij zag een door een mannelijke stem geleide moslimgemeenschap staan, buigen, knielen en zitten. Omdat zowel de uit de spirituele en hemelse wetten bestaande Sharia, als de immateriële gebruiken die voortvloeien uit de bevelen van de Sharia-Eigenaar, onbevattelijk waren voor hem, beeldde hij zich in dat die gemeenschap verbonden was met materiële koorden die hen in gevangenschap hielden en bespeelden. Daarna vertrok hij met een lachwekkende gedachtegang die zelfs de meest barbaarse dieren in menselijke gedaanten tot lachen brengt.</p>

      <p>Voorwaar, zoals in het voorgaande voorbeeld werd het fenomenale legerkamp bestaande uit ontelbare soldaten van de Pre- en Posteeuwige Sultan, wijzend op deze wereld, en de geordende moskee van de Preeeuwige Aanbedene, wijzend op dit universum, betreden door een loochenaar die de puur primitieve, atheïstisch-naturalistische gedachtegang aanhield. De uit de wijsheid der Pre-eeuwige Sultan ontsproten immateriële wetten die binnen de kosmische ordening</p>
        
      <p class="text-end blz-num">31</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="32">
      <p>gelden, beschouwde hij als iets materieels. Tevens veronderstelde hij dat de glorieuze wetgeving in de heerschappij, de universele natuurwetten der Pre-eeuwige Aanbedene, en de bepalingen en regels welke onstoffelijk zijn en slechts existeren in wetenschap, een externe existentie en fysieke verschijningsvorm bezaten. Op grond van die gedachtegang verving hij vervolgens Gods macht met die wetten, dichtte de schepping toe aan hun handen, gaf hen de benaming “natuur” en beschouwde energie – wat slechts een reflectie is van de macht des Heren – als een machtige en zelfonderhoudende heerser. Een dergelijke redenering belijden is echter een duizendmaal lagere primitiviteit dan de primitiviteit uit het voorgaande voorbeeld.</p>

      <p><span class="text-italic">Conclusie:</span> het denkbeeldige en onware dat naturalisten als natuur bestempelen, kan hooguit – als het een uitwendige werkelijkheid bezit – kunst zijn, geen kunstenaar. Het is een weefsel, het kan niet de wever zijn. Het is een bepaling, het kan niet de bepaler zijn. Het is een natuurlijke wet, het kan niet de wetgever zijn. De schepping is een sluier voor glorie, zij kan niet de Schepper zijn. Het is een beïnvloedbaar wezen, het kan niet de Effectuerende Formeerder zijn. Het is een wet, geen kracht; het kan niet de machtsbron zijn. Het is een gevolg, het kan niet de oorsprong zijn.</p>

      <p><span class="text-italic">Tot slot:</span> aangezien het bestaan existeert en aangezien een andere weg buiten de vier wegen om niet volgens rationele richtlijnen is in te beelden, zoals vermeld aan het begin van de Zestiende Notatie, is de invaliditeit van drie uit de vier redeneringen – blijkens drie evi-</p>
        
      <p class="text-end blz-num">32</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="33">
      <p>dente onmogelijkheden op iedere weg – op een absolute wijze bewezen. Wat betreft die vierde weg toont het aan het begin genoemde vers: <sup class="text-underline sup-pointer" title="Bestaat er een twijfel aangaande ALLAH, Die de hemelen en aarde heeft voortgebracht? - De Heilige Qur’an, 14:10">6</sup><span class="text-arabic">اَفِى اللّٰهِ شَكٌّ فَاطِرِ السَّمٰوَاتِ وَالْاَرْضِ</span> onbetwistbaar en ongetwijfeld, op een klaarblijkelijke wijze, de Goddelijkheid aan van de Absoluut Existerende Entiteit en wijst erop dat alles regelrecht aan Zijn machtshand ontspruit en dat zowel de hemelen als de aarde zich onder Zijn bevel bevinden.</p>

      <p>O hopeloze man die gebonden is aan materie en de natuur verafgoodt! Aangezien de natuur van alles, zoals het hele bestaan, geschapen is, want zij is kunstig en nieuwgevormd; en aangezien de externe oorzaak evenzeer kunstig is als het resultaat; en aangezien het bestaan van alles behoeftig is aan vele accessoires en onderdelen, is de existentie van een Absoluut Almachtige Die deze natuur ontwerpt en oorzaken creëert uiteraard een vereiste. En wat voor behoefte zou Die Absoluut Almachtige moeten hebben, dat machteloze oorzaken een inbreng zouden kunnen hebben in Zijn heerschappij en vorming? God verhoede! Hij creëert regelrecht het gevolg gezamenlijk met de oorzaak. Om reflecties van Zijn namen en Zijn wijsheid te tonen door een visuele oorzaak en verbintenis te creëren binnen orde en structuur, maakte Hij oorzaken en de natuur een sluier voor Zijn machtshand, opdat zij als bron dienen voor de ogenschijn-</p>

      <hr class="hr-voetnoot">

      <p class="voetnoot-p"><sup>6 </sup>"Bestaat er een twijfel aangaande ALLAH, Die de hemelen en aarde heeft voortgebracht?" - De Heilige Qur’an, 14:10</p>
        
      <p class="text-end blz-num">33</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="34">
      <p>lijke tekortkomingen, wreedaardigheden en gebreken van creaties. Zodoende waarborgde Hij Zijn glorie.</p>

      <p>Is het voor een klokkenmaker praktischer om eerst de tandwieltjes van een klok te maken en vervolgens die tandwieltjes in die klok te detacheren en te ordenen? Of is het praktischer voor hem om een buitengewone machine in die tandwieltjes te vestigen om de constructie van die klok vervolgens aan de levenloze handen van die machine over te laten opdat zij die klok samenstelt? Valt dit niet buiten het kader van mogelijkheden? Stel die vraag aan jouw onredelijke verstand en oordeel zelf.</p>

      <p>Of neem als voorbeeld een auteur met een pen, inkt en papier tot zijn beschikking. Is het praktischer voor hem om hoogstpersoonlijk een boek eigenhandig te schrijven? Of is het voor hem praktischer om een schrijfapparaat in zijn pen, inkt en papier te vestigen dat specifiek bedoeld is voor dat ene boek, hetgeen kunstiger en lastiger is dan de samenstelling van dat boek, en vervolgens “Schrijf!” te zeggen tegen dat onbewuste apparaat en zichzelf verder buiten te sluiten? Zou dat niet duizendmaal problematischer zijn dan het boek eigenhandig te schrijven?</p>

      <p><span class="text-italic">Mocht jij het volgende stellen:</span> "Inderdaad, het samenstellen van een apparaat welk dat boek schrijft, is duizendmaal problematischer. Het lijkt echter plausibel om dat apparaat als de bron te zien van de vele kopieën van datzelfde boek."</p>
        
      <p class="text-end blz-num">34</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="35">
      <p><span class="text-italic">Het antwoord:</span> de Pre-eeuwige Wever ververst continu de eindeloze reflecties van Zijn namen met Zijn onmetelijke macht om verscheidene manifestaties ervan te demonstreren. Als gevolg heeft Hij gedaanten van materie en specifieke gelaten in een dusdanige vorm geschapen, dat geen enkele brief der Behoefteloze en geen enkel boek des Heren exact identiek is aan één van de overige boeken. Om verschillende betekenissen uit te drukken, zijn er in alle gevallen verscheidene karakteristieken nodig.</p>

      <p>Als jij een oog bezit, observeer dan het gezicht van de mens en zie dat er een gelijkenis is aangaande basisorganen in dit kleine gelaat. Daarnaast staat definitief vast dat elk gelaat, vanaf Adam a.s. tot aan het heden en tot in de eeuwigheid, onderscheidende attributen bezit ten opzichte van overige gelaten. Aldus is elk gelaat een ander boek. Om enkel de kunst erin te ordenen, is er behoefte aan ander schrijfgerei, een andere ordening en een ander handschrift. Daarenboven behoeven zowel de collectering en detachering van materie als de implantatie van alle lichamelijke benodigdheden een volkomen andere werkomgeving.</p>

      <p>Stel, we achten het onmogelijke mogelijk en beschouwen de natuur als een drukkerij. Het werk welk de drukkerij toebehoort is ordenen en drukken; oftewel de specifieke ordening een gedaante geven. In vergelijking daarmee is het echter honderdmaal problematischer om de bouwstoffen waaruit het lichaam van een organisme bestaat, te collecteren vanuit de verste uiteinden van het universum en samen te stellen met</p>
        
      <p class="text-end blz-num">35</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="36">
      <p>een specifieke normering en delicate ordening om die tenslotte te overhandigen aan die drukkerij. Hier is wederom behoefte aan de macht en wilskracht van de Absoluut Almachtige Die ook die drukkerij geschapen heeft. Aldus is dit alternatief betreffende die drukkerij een totaal nietszeggend verzinsel.</p>

      <p>Voorwaar, getuige de voorgaande voorbeelden aangaande de klok en het boek, heeft de Majestueuze Kunstenaar en Alomvattende Almachtige de oorzaken geschapen; ook de resultaten schept Hij. Met Zijn wijsheid koppelt Hij resultaten aan oorzaken. Zowel de ordelijke procesvoering in het universum, bestaande uit een reflectie van Gods universele natuurwetten, vastgesteld door Zijn principiële bepalingen, als de natuurlijke creaturen die slechts een spiegel en reflector zijn van die reflectie, heeft Hij met Zijn wil aangesteld. Tevens heeft Hij het gedeelte van dat proces welk betrokken is bij een externe verschijningsvorm met Zijn macht geformeerd, het creatuur volgens die procedure geschapen en zodoende de natuur en de schepping aan elkaar gekoppeld. Is het nu eenvoudiger om deze zeer gangbare werkelijkheid te aanvaarden, welke het resultaat is van ontelbare bewijzen? Is dit niet een noodzakelijke vereiste? Of is het eenvoudiger om de eindeloze accessoires en onderdelen die benodigd zijn voor de vorming van ieder creatuur te overhandigen aan de levenloze, onbewuste, gecreëerde, gemodelleerde en simplistische dingen welke jullie oorzaken en natuur noemen, opdat zij die diepzinnige en doelbewuste werken verrichten? Is een dergelijke</p>
        
      <p class="text-end blz-num">36</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="37">
      <p>redenering geen ondoenlijke optie? Wij laten het over aan de redelijkheid van jouw onredelijke verstand.</p>

      <p>De loochenende naturalist zei het volgende: "Aangezien u mij uitnodigt tot redelijkheid, zal ik het volgende bekennen: ik geef toe dat het verkeerde pad welk wij tot op heden beliepen op honderden manieren onmogelijk, alsook zeer schadelijk en afgrijselijk lelijk is. Na uw voorgaande analyses vernomen te hebben, zou iemand met het bewustzijn van een atoom zich nog realiseren dat het toedichten van vorming aan oorzaken en de natuur uitgesloten en onmogelijk is. Bovendien is het noodzakelijk en vereist om alles regelrecht te attribueren aan de Absoluut Existerende. Ik zeg: <span class="text-italic">de lof behoort ALLAH toe voor overtuiging</span> en aanvaard het geloof. Ik zit echter met één twijfel. Ik aanvaard dat de Hoogste Gerechtigde de Schepper is. Maar wat voor schade zou Zijn soevereiniteit ervaren wanneer een aantal kleine oorzaken een inbreng hebben bij onbenullige creaties en naar aanleiding daarvan deels lof en glorificatie ondervinden? Zou Zijn soevereiniteit daar minder op worden?"</p>

      <p><span class="text-italic">Het antwoord:</span> zoals op een zeer zekere wijze bewezen in een aantal traktaten, bestaat de essentie van regeren uit verwerping van interventie. Als het aankomt op zijn regeerwijze wijst zelfs een meest simpele regeerder of functionaris de ingreep van zijn bloedeigen zoon af. Dat daarenboven diverse religieuze sultans,</p>
        
      <p class="text-end blz-num">37</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="38">
      <p>ondanks dat ze Khalief waren, hun onschuldige zonen doodden op verdenking van interventie, wijst erop hoe waarlijk deze "verwerping van interventie"-regel heerst binnen het regeren. Van twee wedijverende gouverneurs in een dorp tot aan twee strijdende sultans in een land, uit de geschiedenis met haar bizarre chaos blijkt hoe sterk deze vereiste regel meetelt in het onafhankelijk regeren.</p>

      <p>Als we zien dat de machteloze en hulpbehoevende mens, die een schaduw van gezag en soevereiniteit bezit, op een dusdanige wijze externe interventie verwerpt, bemoeienissen van anderen hindert, deelgenoten voor zijn heerschappij afwijst en de onafhankelijkheid in zijn positie op een bovenmatig intolerabele wijze probeert te behouden, vergelijk dan vervolgens, als je in staat bent, wat voor onontbeerlijke benodigdheid en noodzakelijke vereiste het verwerpen van interventie, hinderen van ingreep en afwijzen van deelgenootschap zou zijn voor een Majestueuze Entiteit, Wiens absolute soevereiniteit op een alom heersend, Wiens absolute gezag op een Goddelijk, Wiens absolute onafhankelijkheid op een individueel en Wiens non-behoeftigheid op een absoluut almachtig niveau is.</p>
        
      <p><span class="text-italic">Wat betreft jouw tweede vorm van twijfel:</span> "Als devoties deels gedirigeerd worden naar een aantal oorzaken bij een aantal kleinigheden, wat zou er dan ontbreken aan de devoties van schepselen – van atomen tot aan planeten – welke gewend zijn tot de Absoluut Existerende Entiteit Die de Waardige Aanbedene is?"</p>

      <p class="text-end blz-num">38</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="39">
      <p><span class="text-italic">Het antwoord:</span> de Soevereine Schepper van deze kosmos schiep het heelal als een boom wiens waardevolste vrucht de bezitters van besef zijn. En onder de bezitters van besef heeft Hij de mens de meest omvattende vrucht gemaakt. Tevens bestaan de waardevolste levensvruchten, de zin en het natuurlijke streven van de mens uit dankbetuiging en aanbidding. Zou Die Ultieme Soeverein en Onafhankelijke Heerser, Die Ene Individuele Die het universum schiep om Zich geliefd en bekend te maken, de mens, die de vrucht is van heel het bestaan, en de meest verheven vruchten van de mens, bestaande uit dankbetuiging en aanbidding, ooit overhandigen aan andere handen? Zou Hij ooit, volledig in strijd met Zijn wijsheid, het resultaat van de schepping en de vruchten van het heelal leiden naar trivialiteit? God verhoede! Zou Hij ooit de gebeden van wezens, op een wijze welke Zijn wijsheid en heerschappij doet verloochenen, afstaan aan anderen? Terwijl Hij tevens met Zijn werken aantoont dat Hij op een grenzeloze wijze Zichzelf geliefd en bekend wil maken, zou Hij Zichzelf dan laten vergeten en het verheven doeleinde der schepping doen verloochenen door de dankbetuigingen, afhankelijkheden, liefdes en devoties van de meest volmaakte schepselen weg te geven aan andere oorzaken? O vriend die naturalisme heeft afgezworen, jij mag het zeggen!</p>

      <p>Hij zei: "De lof behoort ALLAH toe. Afgezien van mijn twee weggewerkte twijfels, heeft u mij twee dusdanig heldere en krachtige bewijzen geleverd aangaande Gods eenheid, dat Hij de Waardige Aanbedene is</p>

      <p class="text-end blz-num">39</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="40">
      <p>en dat er buiten Hem om niets het waard is om aanbeden te worden, dat het verloochenen van die bewijzen een grootspraak is die gelijkstaat aan het ontkennen van de zon in het daglicht.”</p>

      <p class="text-end blz-num">40</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="41">
      <h3 class="text-center">Slot</h3>

      <p>Degene die de atheïstisch-naturalistische gedachtegang afzwoor en tot het geloof trad, zei het volgende:</p>

      <p>“De lof behoort ALLAH toe, ik heb geen twijfels meer. Ik heb enkel een aantal vragen die mijn aandacht getrokken hebben.”</p>

      <p><strong>De eerste vraag:</strong> van heel luie mensen en zij die hun gebeden verwaarlozen, vernemen wij het volgende: “Wat voor behoefte heeft de Hoogste Gerechtigde aan onze gebeden, dat Hij de verwaarlozer van gebeden in de Qur’an zodanig heftig en nadrukkelijk berispt en met helse folteringen bedreigt? Op wat voor wijze siert het de welafgewogen, adequate en rechtvaardige beschrijvingsmethode van de Qur’an om op een nutteloze en kleine overtreding dusdanig fel te reageren?”</p>

      <p><em>Het antwoord:</em> waarlijk, de Hoogste Gerechtigde heeft uiteraard noch behoefte aan jouw gebeden, noch aan iets anders. Echter, jij hebt behoefte aan gebeden; spiritueel gezien ben jij ziek. In vele traktaten hebben wij bewezen dat gebeden dienen als genezingen voor spirituele wonden. Als een genadevolle dokter een patiënt stellig adviseert om medicijnen te nemen die genezend zijn voor zijn ziekte, en de patiënt daarop als volgt reageert: “Wat voor behoefte heb jij aan mijn genezing, dat jij er zo nadrukkelijk op wijst?” zul jij ook inzien hoe loos die opmerking zal zijn.</p>

      <p class="text-end blz-num">41</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="42">

      <p>Wat betreft de felle bedreigingen en heftige bestraffingen in de Qur’an aangaande verzuiming van gebeden: aan een simpele man die een misdrijf begaat, zou een sultan, naargelang het geschonden volksrecht, een felle straf opleggen om zo het recht van zijn volk te beschermen. Op een vergelijkbare wijze schendt een man die de godsdienstoefeningen en gebeden nalaat op een ernstige wijze het recht van alle wezens, welke dienen als het volk der Pre- en Posteeuwige Sultan, en begaat een spiritueel misdrijf, want volmaaktheden van wezens verschijnen op hun naar de Kunstenaar gewende aangezichten middels verheerlijking en aanbidding. Hij die zijn gebeden nalaat, ziet de aanbidding in het bestaan niet en kan die ook niet zien; misschien ontkent hij die zelfs. Wezens, welke zich op een hoge positie bevinden wat betreft aanbidding en verheerlijking, en waarvan een ieder dient als een brief der Behoefteloze en spiegel der Goddelijke namen, verstoot hij op dat moment van hun verheven positie; omdat hij hun toestand tevens waardeloos, functieloos, levenloos en miserabel acht, denigreert hij alle wezens, verloochent hun volmaaktheid en schendt hun rechten.</p>

      <p>Voorwaar, iedereen ziet de wereld zoals die in zijn eigen spiegel verschijnt. De Hoogste Gerechtigde heeft de mens als criterium en balans voor het bestaan geschapen. Aan ieder mens heeft Hij binnen deze wereld een specifieke wereld geschonken. God toont de kleuren van die wereld naar het begrip van zijn hart. Bijvoorbeeld, een mens die op een zeer hopeloze en</p>

      <p class="text-end blz-num">42</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="43">

      <p>bedroefde wijze weent, ziet de wereld in een wenende en hopeloze staat. Een zeer vrolijke en fleurige man die lacht vanwege zijn volle hoop en vrolijkheid, ziet de wereld in een lachende en fleurige staat. Een man die op een plechtige en bezinnende wijze gebeden en verheerlijkingen verricht, ontdekt en ziet in zekere mate de waarachtige aanbiddingen en verheerlijkingen van wezens welke wezenlijk plaatsvinden. Een man die door dwaling of verloochening aanbidding nalaat, beeldt de staat van wezens in op een wijze welke volkomen vals, botsend en contrair is ten opzichte van hun ware volmaaktheid. Zodoende schendt hij spiritueel gezien hun rechten.</p>

      <p>Omdat die verwaarlozer van gebeden zichzelf evenmin bezit, doet hij zijn eigen ziel, welke onderdaan is van zijn Heerser, onrecht aan. Zijn Heerser bedreigt hem op een intense wijze opdat het recht dat die onderdaan toekomt, gepakt wordt van zijn ego. Vanwege het nalaten van gebeden, welke de vruchten der schepping en ingeschapen strevens zijn, impliceert die nalatigheid bovendien het schenden van Goddelijke wijsheid en een verzoek des Heren. Daarom zal hij foltering ondergaan.</p>

      <p><em>Tot besluit:</em> iemand die aanbidding verzuimt, doet én zijn ziel onrecht aan – de ziel die de onderdaan is van de Hoogste Gerechtigde en Hem toebehoort – én hij schendt de volmaakte rechten van de schepping. Waarlijk, zoals atheïsme een belediging is voor het bestaan, is het nalaten van gebeden een verloochening van de volmaaktheid der schepping. Omdat het daar-</p>

      <p class="text-end blz-num">43</p>
      <hr class="hr-blz">
    </div>
    
    <div class="pagenumber" id="44">

      <p>enboven Goddelijke wijsheid schendt, bestaat hetgeen hem toekomt uit heftige dreigementen en ernstige folteringen.</p>

      <p>Voorwaar, om dit toebehoren en deze beschreven werkelijkheid te omschrijven, verkoos de miraculeus uiteengezette Qur’an op een miraculeuze wijze die felle beschrijvingsmethode, welke onder pure eloquentie valt; oftewel de toepassing van het best geplaatste woordgebruik naar de situatie.</p>

      <p><strong>De tweede vraag</strong></p>

      <p>De man die naturalisme afzwoor en tot het geloof trad, zei het volgende: “De verbondenheid met de wil van ALLAH en Zijn macht over ieder wezen, in ieder opzicht, met alle handelingen en elke eigenschap, is een fenomenale werkelijkheid. De fenomenaliteit ervan maakt het onbevattelijk voor ons beperkte verstand. De bovenmatige overvloed welke wij met onze ogen waarnemen, de grenzeloze eenvoud binnen de creatie en vorming van creaturen, de eindeloze souplesse en eenvoud van vorming op het pad van Goddelijke eenheid – welke zich voltrekt zoals beschreven in uw voorgaande bewijzen – en het uiterste gemak dat openlijk getoond wordt in verzen zoals:</p>

      <p class="text-center text-arabic"><sup class="text-underline sup-pointer" title="Zowel jullie schepping als jullie wederopstanding is zoals die van één ziel. - De Heilige Qur’an, 31:28">8</sup> مَا خَلْقُكُمْ وَلَا بَعْثُكُمْ اِلَّا كَنَفْسٍ وَاحِدَةٍ</p>

      <hr class="hr-voetnoot">

      <p class="voetnoot-p"><sup>8 </sup>"Zowel jullie schepping als jullie wederopstanding is zoals die van één ziel." - De Heilige Qur’an, 31:28</p>

      <p class="text-end blz-num">44</p>
      <hr class="hr-blz">

    </div>

    <div class="pagenumber" id="45">

      <p class="text-center text-arabic"><sup class="text-underline sup-pointer" title="En het uur zal in een oogwenk, of nog spoediger plaatsvinden.
        - De Heilige Qur’an, 16:77">9</sup> وَمَٓا اَمْرُ السَّاعَةِ اِلَّا كَلَمْحِ الْبَصَرِ اَوْ هُوَ اَقْرَبُ</p>

      <p>tonen daarentegen aan dat die fenomenale werkelijkheid een meest aanvaardbare en rationele zaak is. Wat is het geheim en wijsheid achter deze eenvoud?</p>

      <p><em>Het antwoord:</em> <strong>de Tiende Term</strong> van <strong>de Twintigste Brief</strong> waarin het vers <span class="text-center text-arabic"><sup class="text-underline sup-pointer" title="En Hij heeft de macht over alles. - De Heilige Qur’an, 30:50">10</sup> وَهُوَ عَلٰى كُلِّ شَىْءٍ قَدٖيرٌ</span> wordt uiteengezet, verklaart dat geheim op een zeer heldere, absolute en doorslaggevende wijze. Met name in de bijlage van die brief wordt op een nog duidelijkere wijze bewezen dat de vorming van heel het bestaan zo eenvoudig wordt als die van één wezen wanneer het geattribueerd wordt aan de Ene Kunstenaar. Als alles niet wordt geattribueerd aan de Ene Individuele, wordt de vorming van één wezen zo problematisch als die van heel het bestaan. De vorming van een zaad wordt dan zo lastig als die van een boom.</p>

      <p>Als formatie wordt geattribueerd aan de Ware Kunstenaar, dan wordt de vorming van het heelal zo eenvoudig als die van een boom, die van een boom zo eenvoudig als die van een zaadje, die van het paradijs zo eenvoudig als die van de lente en die van de lente zo eenvoudig als die van een bloem; aldus vindt souplesse plaats.</p>

      <hr class="hr-voetnoot">

      <p class="voetnoot-p"><sup>9 </sup>"En het uur zal in een oogwenk, of nog spoediger plaatsvinden."
        - De Heilige Qur’an, 16:77</p>
      <p class="voetnoot-p"><sup>10 </sup>"En Hij heeft de macht over alles." - De Heilige Qur’an, 30:50</p>

      <p class="text-end blz-num">45</p>
      <hr class="hr-blz">

    </div>

    <div class="pagenumber" id="46">

      <p>We gaan bondig verwijzen naar enkele van de honderden in diverse traktaten uiteengezette bewijzen aangaande de bron van het geheim en de wijsheid achter de klaarblijkelijke overvloedige overvloed en moeiteloosheid, de probleemloze presentie van menig individu uit iedere levensvorm en de algemene eenvoud en rapheid in de soepele totstandkoming van geordende, kunstige en waardevolle wezens.</p>

      <p>Zoals het honderdmaal eenvoudiger is om honderd soldaten te plaatsen onder het bevel van één officier dan om één soldaat te plaatsen onder het bevel van honderd officieren, is de eenvoud in de regeling van legeraccessoires voor een heel leger kwantitatief gelijk aan die van één soldaat wanneer één centrum, één wet, één fabriek en één koningsbevel daar verantwoordelijk voor zijn. Anderzijds is de regeling van accessoires voor één soldaat kwantitatief zo problematisch als de regeling van accessoires voor een heel leger wanneer de verantwoordelijkheid op verscheidene centra, verscheidene fabrieken en verscheidene bevelhebbers rust.Want voor de accessoires van één enkele soldaat is er behoefte aan de fabrieken welke benodigd zijn voor een compleet leger.</p>

      <p>Vanuit het perspectief van het eenheidsgeheim is tevens klaarblijkelijk te zien dat een boom duizenden vruchten geeft met het gemak van één vrucht, omdat zijn levensmiddelen worden gegeven vanuit één wortel, één centrum en één wet. Als eenheid wordt omgezet in diversiteit en de benodigde levensmiddelen van elke vrucht vanuit verschillende bronnen worden</p>

      <p class="text-end blz-num">46</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="47">

      <p>gegeven, wordt de totstandkoming van iedere vrucht zo problematisch als de totstandkoming van een boom. Bovendien wordt zelfs de vorming van één enkel zaadje, welk een exemplaar en samenvatting is van een boom, zo problematisch als de vorming van die boom; want de benodigde levensmiddelen die vereist zijn voor het voortleven van een boom, zijn evenzeer vereist voor een zaadje.</p>

      <p>Voorwaar, zo zijn er honderden vergelijkbare voorbeelden die allen aantonen dat duizenden wezens die op basis van eenheid met uiterst gemak tot stand komen, eenvoudiger ontstaan dan één enkel wezen uitgaande van afgoderij of diversiteit. Omdat deze werkelijkheid in diverse traktaten met absolute zekerheid bewezen is, verwijzen wij voor meer details naar die werken. Hier zullen wij vanuit de gezichtspunten van voorkennis, Goddelijke beschikking en de macht des Heren telkens één zeer belangrijk geheim omtrent dit gemak en deze eenvoud uiteenzetten.</p>

      <p>Jij bent een wezen. Als jij jezelf attribueert aan de Pre-eeuwige Almachtige, schept Hij jou, net als het strijken van een lucifersstokje, vanuit nul, vanuit het niets, ogenblikkelijk met Zijn bevel en eindeloze macht. Als jij jezelf niet aan Hem attribueert, maar aan materiële oorzaken toedicht, dan behoren het heelal en de elementen met een fijne filter gefilterd, en de bouwstoffen van jouw lichaam met een accurate afweging vanuit alle hoeken van de kosmos gecollecteerd te worden, opdat jij geformeerd kan worden; want jij bent een geordende index, de vrucht, de samenvatting</p>

      <p class="text-end blz-num">47</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="48">

      <p>en het miniregister van het heelal. Materiële oorzaken ordenen en verzamelen slechts. Dat die niet in staat zijn om hetgeen zich niet in hun bereik bevindt uit het niets te scheppen, wordt door iedere bezitter van een verstand bevestigd. Aldus zijn zij genoodzaakt om het lichaam van een minuscuul organisme te collecteren vanuit heel het heelal. Voorwaar, besef dus wat voor eenvoud er zich in eenheid en individualiteit bevindt en wat voor problematiek er zich in afgoderij en dwaling bevindt.</p>

      <p><em>Ten tweede</em> is er in eenheid een grenzeloze eenvoud vanuit het gezichtspunt van voorkennis. Het lot is een aspect van Goddelijke kennis waarin de geestelijke en specifieke gedaantes van alles is vastgesteld. Vervolgens dient die voorbeschikte vaststelling als een ontwerpplan en model van een creatuur. Wanneer macht formeert, formeert die op een zeer soepele wijze volgens die voorbestemde vaststelling. Als dat creatuur niet wordt geattribueerd aan de Majestueuze Almachtige, Die Bezitter is van een alomvattende, eindeloze en pre-eeuwige wijsheid, ontstaan er geen duizenden problemen, zoals voorheen beschreven, maar honderden onmogelijkheden; want als die voorbeschikte vaststelling en de voorkennis van die vaststelling niet zouden bestaan, zouden duizenden materiële mallen met een externe existentie binnenin het lichaam van een minuscuul diertje ingezet moeten worden.</p>

      <p>Voorwaar, doorzie een geheim aangaande de eindeloze eenvoud in eenheid en eindeloze problematiek in afgoderij en besef welk een wezenlijke, feitelijke en</p>

      <p class="text-end blz-num">48</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="49">

      <p>verheven werkelijkheid er beschreven wordt in het vers:</p>

      <p class="text-center text-arabic"><sup class="text-underline sup-pointer" title="En het uur zal in een oogwenk, of nog spoediger plaatsvinden. - De Heilige Qur’an, 16:77">11</sup> وَمَٓا اَمْرُ السَّاعَةِ اِلَّا كَلَمْحِ الْبَصَرِ اَوْ هُوَ اَقْرَبُ</p>

      <p><strong>De derde vraag</strong></p>

      <p>De vroeger vijandige bekeerling die nu metgezel is, zei het volgende: "De extreem buitensporige filosofen van tegenwoordig zeggen: 'Niets wordt uit het niets geschapen en niets vergaat; creaturen ondergaan slechts een samenstelling en ontbinding waardoor de kosmische fabriek in werking wordt gezet.'"</p>

      <p><em>Het antwoord:</em> de meest voorname filosofen die het bestaan zonder Qur’anisch licht aanschouwden, splitsten zich in twee groepen nadat zij inzagen – op een wijze zoals voorheen beschreven – dat de vorming en totstandkoming van dit bestaan middels de natuur en oorzaken ondoenlijk problematisch is.</p>

      <p>De ene groep werd sofist en zonk tot een nog lager niveau dan dwaze dieren door afstand te doen van het distinctieve kenmerk van de mens: het verstand. Ze achtten de verloochening van het bestaan en zelfs de existentie van henzelf aannemelijker dan de leer van het dwaalpad welk de natuur en oorzaken als scheppers beschouwt en vervielen zodoende tot ultieme onwetendheid door zowel henzelf als het universum te verloochenen.</p>

      <hr class="hr-voetnoot">

      <p class="voetnoot-p"><sup>11 </sup>"En het uur zal in een oogwenk, of nog spoediger plaatsvinden."
        - De Heilige Qur’an, 16:77</p>
      
      <p class="text-end blz-num">49</p>
      <hr class="hr-blz">

    </div>

    <div class="pagenumber" id="50">

      <p>De tweede groep zag dat de vorming aan natuur toedichtende dwaalleer eindeloze problematiek bevatte als het aankomt op de vorming van een vliegje en een zaadje. Tevens was er een macht nodig tot welke het verstandsvermogen niet reikte.</p>

      <p>Noodgedwongen loochenden zij daardoor vorming en zeiden:</p>

      <p>"Iets kan niet uit niets ontstaan."</p>

      <p>Evenzeer achtten zij verdoemenis onmogelijk en oordeelden als volgt:</p>

      <p>"Existentie vergaat niet."</p>

      <p>Zij fantaseren slechts over een samenstelling, ontbinding, separatie en assemblage middels de beweging van atomen en stormen van toevalligheden welke resulteren in de visuele staat van het bestaan.</p>

      <p>Waarlijk, kom nu de mensen bezichtigen die zich op het laagste niveau van dwaasheid en onwetendheid bevinden, terwijl ze zichzelf het intelligentst achten. Besef hoe bespottelijk, verachtelijk en dwaas een mens kan worden door dwaling en trek er lering uit.</p>

      <p>Het bezit van gegevens met betrekking tot wezens waarin planning en kwantiteit worden vastgesteld binnen de kring van pre-eeuwige kennis, en de zeer eenvoudige externe vormgeving aan data van wezens waarvan de uitwendige existentie niet bestaat, zoals het aanbrengen van een substantie op een geschrift geschreven met onzichtbaar inkt om de tekst te doen verschijnen, te hoog gegrepen en onmogelijk achten</p>

      <p class="text-end blz-num">50</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="51">

      <p>voor een pre-eeuwige macht welke elk jaar vierhonderdduizend levensvormen gelijktijdig vormgeeft op het aardoppervlak, de hemelen en aarde schiep in zes dagen en elke lente in zes weken een levende wereld samenstelt welke kunstiger en diepzinniger is dan het heelal, en ten gevolge van die gedachtegang vorming verloochenen, is een grotere dwaasheid en onwetendheid dan die van de voornoemde groep sofisten.</p>

      <p>Waarlijk, de Absoluut Almachtige heeft zowel een scheppende als constructieve wijze van vorming. Nonexistentie een bestaan geven en een existenterende doen vergaan is de meest eenvoudige en gangbare wet welke zelfs onophoudelijk universeel wordt toegepast.</p>

      <p>Non-existentie behoort hem toe die uitingen maakt als: ‘Non-existentie kan Hij geen bestaan schenken’ over een macht welke gedurende de lente vanuit het niets existentie schenkt aan de vormen, eigenschappen en – op atomen na – alle karakteristieken en gesteldheden van driehonderdduizend levensvormen.</p>

      <p>De man die naturalisme afzwoor en de waarheid omarmde, zei het volgende:</p>

      <p>"Ik dank, loof en verheerlijk de Hoogste Gerechtigde naar het aantal atomen aanwezig in het bestaan, want ik heb het volmaakte geloof verworven, ben gered van zowel onzekerheid als dwaling en heb er geen greintje twijfel aan overgehouden."</p>

      <p class="text-end blz-num">51</p>
      <hr class="hr-blz">
    </div>

    <div class="pagenumber" id="52">

      <p class="text-center text-arabic"><sup class="text-underline sup-pointer" title="De lof behoort ALLAH toe voor de Islamitische religie en volmaakte overtuiging.">12</sup> اَلْحَمْدُ لِلّٰهِ عَلٰى دٖينِ الْاِسْلَامِ وَ كَمَالِ الْاٖيمَانِ</p>

      <p class="text-center text-arabic"><sup class="text-underline sup-pointer" title="U bent Feilloos. Behalve hetgeen U ons onderwijst, beschikken wij over geen kennis. U bent zonder twijfel de Alwetende, de Alwijze. - De Heilige Qur’an, 2:32">13</sup> سُبْحَانَكَ لَا عِلْمَ لَنَٓا اِلَّا مَا عَلَّمْتَنَٓا اِنَّكَ اَنْتَ الْعَلٖيمُ الْحَكٖيمُ</p>

      <hr class="hr-voetnoot">

      <p class="voetnoot-p"><sup>12 </sup>"De lof behoort ALLAH toe voor de Islamitische religie en volmaakte
        overtuiging."</p>
      <p class="voetnoot-p"><sup>13 </sup>"U bent Feilloos. Behalve hetgeen U ons onderwijst, beschikken wij over geen kennis. U bent zonder twijfel de Alwetende, de Alwijze." - De Heilige Qur’an, 2:32</p>
      
      <p class="text-end blz-num">52</p>
      <hr class="hr-blz">

    </div>      
    
    <div id="popup" style="display: none; position: fixed; top: 30%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;">
      <p class="pop-up-message">Er zijn geen resultaten gevonden!</p>
      <button id="closePopup" style="margin-top: 10px;">Sluiten</button>
    </div>

  </div> 

<script>
  let currentBook = "Het Traktaat over de Natuur"
  let bookUrlJS = "/het-traktaat-over-de-natuur"
  let currentBookStore = "het-traktaat-over-de-natuur"
</script>

<?php include('includes/footer-book-page.php'); ?>