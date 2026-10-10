# Skladový systém

**Autor:** Tomáš Ďurčan  
**Študijná skupina:** 5ZYI32

---

## Stručný opis projektu

Výstupom tejto práce je webová aplikácia, ktorá bude slúžiť na správu skladového hospodárstva výrobného podniku. Slúži na efektívne riadenie, sledovanie a optimalizáciu množstva zásob a materiálov, súčiastok a hotových výrobkov. Systém rieši problém neprehľadnosti v zásobách, predchádza výpadkom vo výrobnom procese a znižuje problémy pri objednávaní, prijímaní a vydávaní tovaru zo skladu.

Aplikácia je určená pre pracovníkov skladu, vedúcich výroby a manažment. Hlavným účelom aplikácie je poskytnúť aktuálny pohľad na stav zásob, upozorňovať na rizikové množstvá zásob, naopak aj oznámiť saturované materiály. Systém dokáže automaticky vytvoriť objednávku na nedostatkový materiál.

---

## Role v projekte

### Pracovník skladu (Skladník)
* Základné operačné práva pre každodennú manipuláciu s tovarom a materiálom.
* Fyzický príjem a výdaj tovaru zo skladu, evidencia pohybov (príjemky, výdajky), kontrola fyzického umiestnenia položiek v skladových lokáciách. Nemá právo upravovať cenníky, mazať položky z katalógu ani meniť systémové nastavenia.

### Vedúci skladu / Vedúci výroby
* Rozšírené manažérske práva nad materiálom, výrobou a dodávateľmi (zahrňuje všetky oprávnenia skladníka).
* Správa katalógu zásob (CRUD operácie nad materiálom), nastavovanie limitov zásob (kritická a saturovaná úroveň), vytváranie a správa výrobných príkazov, manuálne korekcie/inventúry stavu skladov a generovanie dodávateľských objednávok na chýbajúci materiál.

### Správca systému (Admin)
* Najvyššie systémové a administratívne práva (zahrňuje všetky oprávnenia vedúceho skladu).
* Kompletná správa používateľských účtov (vytváranie, úprava, blokovanie, mazanie), pridatovanie rolí používateľom, kontrola systémových logov, zálohovanie a konfigurácia globálnych parametrov aplikácie.

---

## Prípady použitia podľa rolí

### Pracovník skladu
* prehliada zoznam zásob, filtruje položky na základe kódu, názvu, množstva, stavu (kritický/saturovaný),
* vytvorenie príjemky, evidencia nového materiálu,
* vytvorenie výdajky, evidencia vyskladnenia materiálu.

### Vedúci výroby / Vedúci skladu
* vytvorenie novej položky v katalógu zásob alebo upravenie existujúcich údajov,
* odstránenie položky z katalógu,
* nastavenie kritickej a saturovanej hodnoty zásob,
* manuálne nastavenie množstva materiálu na sklade (poškodenie, na základe inventúry),
* vytvorenie výrobného príkazu,
* vygenerovanie objednávky na materiál.

### Správca / Manažér systému
* vytvorenie nového používateľského účtu, priradenie zodpovedajúcej roly,
* upravenie údajov existujúceho používateľa,
* deaktivácia a vymazanie používateľského účtu,
* vie si pozrieť zoznam používateľov.

---

## Plánované entity

* **User** (Reprezentuje zamestnanca pracujúceho so systémom):
    * `id`
    * `name`
    * `surname`
    * `email`
    * `password` (hash)
    * `role`
    * `created_at` (dátum vytvorenia účtu)

* **Item** (Skladová položka / Materiál / Výrobok - reprezentuje konkrétny typ materiálu alebo výrobku):
    * `id`
    * `code`
    * `name`
    * `description`
    * `measurement_unit` (ks, kg, m)
    * `min_stock`
    * `saturated_stock`
    * `current_stock`
    * `price_for_unit`
    * `category`

* **StockMovement** (Skladový pohyb - Príjemka/Výdajka - eviduje príjem alebo výdaj zo skladu):
    * `id`
    * `type`
    * `date`
    * `supplier_id`
    * `user_id`
    * `note`

* **MovementItem** (Spojovacia entita pre konkrétne položky na príjemke/výdajke):
    * `movement_id`
    * `item_id`
    * `amount`

* **Supplier** (Firma dodávajúca materiál):
    * `id`
    * `name`
    * `ico`
    * `email`
    * `phone_number`
    * `address`

* **ProductionOrder** (Výrobný príkaz - plánovaná alebo prebiehajúca výroba hotového výrobku):
    * `id`
    * `product_id`
    * `amount`
    * `state`
    * `date`

---

## Vzťahy medzi entitami

* **User (1) : StockMovement (N)**  
  Jeden používateľ môže zaevidovať viacero skladových pohybov.

* **Supplier (1) : StockMovement (N)**  
  Podobne ako pri vzťahu User : StockMovement, jeden dodávateľ môže vystupovať vo viacerých príjemkách.

* **StockMovement (M) : Item (N)**  
  Vzťah typu M:N dekomponovaný prostredníctvom asociačnej entity `MovementItem`.  
  Jedna príjemka alebo výdajka môže obsahovať viacero rôznych skladových položiek a zároveň jedna skladová položka môže figurovať v mnohých históriách pohybov.

* **Item (1) : ProductionOrder (N)**  
  Jeden výrobok môže byť predmetom viacerých výrobných príkazov.

---

## Hlavné stránky aplikácie

1. **Domovská stránka**  
   Súhrnný panel na zobrazenie kľúčových ukazovateľov skladu (celkový počet položiek, upozornenia na položky v kritickom stave a pod.).

2. **Katalóg skladových zásob**  
   Zoznam všetkých evidovaných položiek na sklade s možnosťou filtrovania podľa kategórie, stavu zásob. Vedúci skladu má na tejto stránke možnosť zmeniť stav zásob, pridanie alebo odstránenie položiek.

3. **Detail skladovej položky**  
   Zobrazenie podrobných informácií o konkrétnom materiáli alebo výrobku, nastavenej minimálnej/saturovanej úrovne a kompletnej histórie jeho príjmov a výdajov.

4. **Evidencia skladových pohybov (Príjemky a výdajky)**  
   Formulár a zoznam pre zaevidovanie fyzického príjmu materiálu od dodávateľa alebo jeho výdaja do výroby. Umožňuje výber dodávateľa, pridanie položiek s ich množstvami.

5. **Správa výrobných príkazov**  
   Obrazovka určená pre vedúceho výroby na plánovanie a sledovanie stavu výroby (plánovaná, prebiehajúca, dokončená). Umožňuje zadávať nové výrobné príkazy, ktoré automaticky zarezervujú požadovaný materiál zo skladu.

6. **Správa používateľov**  
   Obrazovka prístupná výhradne pre správcu systému. Slúži na správu používateľských účtov (vytváranie nových účtov, úprava profilov, prideľovanie rolí a mazanie používateľov).

---

## Rozdelenie funkcionality

### Základné funkcie
* Správa a autentifikácia používateľov
* Zoznam skladových zásob
* Evidencia pohybov zásob v sklade
* Správa výrobných príkazov

(Implementovaním týchto funkcií by mali byť splnené povinné podmienky.)

### Rozširujúce funkcie
* Generovanie objednávok materiálu
* Nahrávanie súborov reprezentujúcich objednávku