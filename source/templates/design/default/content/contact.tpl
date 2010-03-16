<table border="0" cellpadding="5" cellspacing="0" class="contentTable" width="100%">
<tr>
	<td class="title">
		{$item_arr[0].Title}
	</td>
</tr>
<tr>
    <td>
		{$item_arr[0].Full_Text}
	</td>
</tr>
<tr>
	<td class="more">
		<a href="/index.php?{$MODULE}=content_print&id={$item_arr[0].ID}" target="_blank">{lang print}&nbsp;<img src="{$design_images}/print.gif"  border="0"></a>
	</td>
</tr>
</table>
<br />
<br />
<br />

<noscript> 
<!--
<TABLE cellSpacing=0 cellPadding=10 width="100%" border=0>
<TBODY>
<TR>
  <TD>
  

<script language="javascript">
{literal}

function isEmail(string) {
//    if (string.search(/^(\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+(;|,|$))+$/) != -1)
    if (string.search(/^(\w+[\w.-]*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+(;|,|$))+$/) != -1)
        return true;
    else
        return false;
}

function validate_form(cform)
{
  var form = document.contact;
  var cform = document.contact;
   
  if (form.captcha.value.length < 1) {
        alert('Пожалуйста, введите код');
        form.captcha.focus();
        return false;
    }
    if (form.captcha.value.length != 4) {
        alert('Вы ввели неправильный код');
        form.captcha.focus();
        return false;
    }
    //var captcha = eval('captcha_'+form.captchaSID.value);
    //if (captcha.length < 1) {
    //    alert('Пожалуйста, подождите, пока загрузится картинка с кодом или включите поддержку cookie в Вашем браузере');
    //    form.captcha.focus();
    //    return false;
    //}
    if (document.getElementById('sid').value != document.getElementById('captcha').value) {
        alert('Вы ввели неправильный код');
        form.captcha.focus();
        return false;
    }
  
  if(cform.req_firstname.value.length<1){
     alert("Пожалуйста, введите имя!");
     cform.firstname.focus();
     return false;
  }

  if(cform.req_lastname.value.length<1){
     alert("Пожалуйста, введите фамилию!");
     cform.lastname.focus();
     return false;
  }

  if(cform.req_email.value.length<1){
     alert("Пожалуйста, введите Адрес E-mail!");
     cform.req_email.focus();
     return false;
  } else if(isEmail(cform.req_email.value) == false) {
     alert('Пожалуйста, введите правильный Адрес E-mail!');
     cform.req_email.focus();
     return false;
  }

  if(cform.req_info.value.length<1){
     alert("Пожалуйста, введите Вопрос!");
     cform.info.focus();
     return false;
  }


form.protected_field.value = 1977;

  document.contact.submit();	
  return true;
}
{/literal}
</script>

<form name="contact" method="post">
<table border="0">

<tr>

  <td width="250">Имя:
<sup><strong>*</strong></sup>
</td>
  <td width="200"><input type="text" class="form_item" name="req_firstname" value="" size="29"></td>
</tr>

<tr>
  <td width="200">Фамилия:
<sup><strong>*</strong></sup>
</td>
  <td width="200"><input type="text" class="form_item" name="req_lastname" value="" size="29"></td>

</tr>

<tr>
  <td>Адрес E-mail:
<sup><strong>*</strong></sup>
</td>
  <td><input type="text" class="form_item" name="req_email" value="" size="29"></td>
</tr>

<tr>
  <td>Телефон:</td>
  <td><input type="text" class="form_item" name="req_phone" value="" size="29"></td>

</tr>

<tr>
  <td width="200">Адрес:</td>
  <td width="200"><input type="text" class="form_item" name="req_address1" value="" size="29"></td>
</tr>

<tr>
  <td width="200">Адрес 2:</td>
  <td width="200"><input type="text" class="form_item" name="req_address2" value="" size="29"></td>
</tr>

<tr>
  <td>Город:</td>
  <td><input type="text" name="req_city" class="form_item" value="" size="29"></td>
</tr>

<tr>
  <td>Страна:</td>
  <td>
    <select name="req_country">

    
<option value="Австралия">Австралия</option>

<option value="Австрия">Австрия</option>

<option value="Азербайджан">Азербайджан</option>

<option value="Албания">Албания</option>

<option value="Алжир">Алжир</option>

<option value="Американская Самоа">Американская Самоа</option>

<option value="Ангола">Ангола</option>

<option value="Ангуилла">Ангуилла</option>

<option value="Андорра">Андорра</option>

<option value="Антартика">Антартика</option>

<option value="Антигуа">Антигуа</option>

<option value="Аргентина">Аргентина</option>

<option value="Армения">Армения</option>

<option value="Аруба">Аруба</option>

<option value="Афганистан">Афганистан</option>

<option value="Багамы">Багамы</option>

<option value="Бангладеш">Бангладеш</option>

<option value="Барбадос">Барбадос</option>

<option value="Бахрейн">Бахрейн</option>

<option value="Белиз">Белиз</option>

<option value="Белоруссия">Белоруссия</option>

<option value="Бельгия">Бельгия</option>

<option value="Бенин">Бенин</option>

<option value="Берег слоновой кости">Берег слоновой кости</option>

<option value="Бермуды">Бермуды</option>

<option value="Болгария">Болгария</option>

<option value="Боливия">Боливия</option>

<option value="Босния-Герцеговина">Босния-Герцеговина</option>

<option value="Ботсвана">Ботсвана</option>

<option value="Бразилия">Бразилия</option>

<option value="Бруней">Бруней</option>

<option value="Буветские острова">Буветские острова</option>

<option value="Буркина фасо">Буркина фасо</option>

<option value="Бурунди">Бурунди</option>

<option value="Бутан">Бутан</option>

<option value="Вануату">Вануату</option>

<option value="Ватикан">Ватикан</option>

<option value="Великобритания">Великобритания</option>

<option value="Венгрия">Венгрия</option>

<option value="Венесуэла">Венесуэла</option>

<option value="Виргинские о-ва (британия)">Виргинские о-ва (британия)</option>

<option value="Виргинские о-ва (сша)">Виргинские о-ва (сша)</option>

<option value="Вьетнам">Вьетнам</option>

<option value="Габон">Габон</option>

<option value="Гаити">Гаити</option>

<option value="Гайана">Гайана</option>

<option value="Гамбия">Гамбия</option>

<option value="Гана">Гана</option>

<option value="Гватемала">Гватемала</option>

<option value="Гвинея">Гвинея</option>

<option value="Гвинея-Бисау">Гвинея-Бисау</option>

<option value="Германия">Германия</option>

<option value="Гибралтар">Гибралтар</option>

<option value="Голландия">Голландия</option>

<option value="Гондурас">Гондурас</option>

<option value="Гонконг">Гонконг</option>

<option value="Гренада">Гренада</option>

<option value="Гренладния">Гренладния</option>

<option value="Греция">Греция</option>

<option value="Грузия">Грузия</option>

<option value="Гуам (США)">Гуам (США)</option>

<option value="Дания">Дания</option>

<option value="Джибути">Джибути</option>

<option value="Доминика">Доминика</option>

<option value="Доминиканская республика">Доминиканская республика</option>

<option value="Египет">Египет</option>

<option value="Заир">Заир</option>

<option value="Замбия">Замбия</option>

<option value="Западная Сахара">Западная Сахара</option>

<option value="Зимбабве">Зимбабве</option>

<option value="Израиль">Израиль</option>

<option value="Индия">Индия</option>

<option value="Индонезия">Индонезия</option>

<option value="Иордания">Иордания</option>

<option value="Ирак">Ирак</option>

<option value="Иран">Иран</option>

<option value="Ирландия">Ирландия</option>

<option value="Исландия">Исландия</option>

<option value="Испания">Испания</option>

<option value="Италия">Италия</option>

<option value="Йемен">Йемен</option>

<option value="Кабо-Верде">Кабо-Верде</option>

<option value="Казахстан">Казахстан</option>

<option value="Каймановы острова">Каймановы острова</option>

<option value="Камбоджа">Камбоджа</option>

<option value="Камерун">Камерун</option>

<option value="Канада">Канада</option>

<option value="Катар">Катар</option>

<option value="Кения">Кения</option>

<option value="Кипр">Кипр</option>

<option value="Киргизия">Киргизия</option>

<option value="Кирибати">Кирибати</option>

<option value="Китай">Китай</option>

<option value="Кокосовые острова">Кокосовые острова</option>

<option value="Колумбия">Колумбия</option>

<option value="Коморы">Коморы</option>

<option value="Конго">Конго</option>

<option value="Корея Северная">Корея Северная</option>

<option value="Корея Южная">Корея Южная</option>

<option value="Коста-Рика">Коста-Рика</option>

<option value="Кристмасовы острова">Кристмасовы острова</option>

<option value="Куба">Куба</option>

<option value="Кувейт">Кувейт</option>

<option value="Кука острова">Кука острова</option>

<option value="Лаос">Лаос</option>

<option value="Латвия">Латвия</option>

<option value="Лесото">Лесото</option>

<option value="Либерия">Либерия</option>

<option value="Ливан">Ливан</option>

<option value="Ливия">Ливия</option>

<option value="Литва">Литва</option>

<option value="Лихтенштейн">Лихтенштейн</option>

<option value="Люксембург">Люксембург</option>

<option value="Маврикий">Маврикий</option>

<option value="Мавритания">Мавритания</option>

<option value="Мадагаскар">Мадагаскар</option>

<option value="Макао">Макао</option>

<option value="Малави">Малави</option>

<option value="Малайзия">Малайзия</option>

<option value="Мали">Мали</option>

<option value="Мальдивы">Мальдивы</option>

<option value="Мальта">Мальта</option>

<option value="Марокко">Марокко</option>

<option value="Мартиника">Мартиника</option>

<option value="Маршалловы острова">Маршалловы острова</option>

<option value="Мексика">Мексика</option>

<option value="Микронезия">Микронезия</option>

<option value="Мозамбик">Мозамбик</option>

<option value="Молдавия">Молдавия</option>

<option value="Монако">Монако</option>

<option value="Монголия">Монголия</option>

<option value="Монтесерат">Монтесерат</option>

<option value="Мьянма">Мьянма</option>

<option value="Намибия">Намибия</option>

<option value="Науру">Науру</option>

<option value="Нейтральная Зона">Нейтральная Зона</option>

<option value="Непал">Непал</option>

<option value="Нигер">Нигер</option>

<option value="Нигерия">Нигерия</option>

<option value="Нидерландские Антильские острова">Нидерландские Антильские острова</option>

<option value="Никарагуа">Никарагуа</option>

<option value="Ниу">Ниу</option>

<option value="Новая Зеландия">Новая Зеландия</option>

<option value="Новая Каледония">Новая Каледония</option>

<option value="Норвегия">Норвегия</option>

<option value="Норфолк остров">Норфолк остров</option>

<option value="Объединенные Арабские Эмираты">Объединенные Арабские Эмираты</option>

<option value="Оман">Оман</option>

<option value="Пакистан">Пакистан</option>

<option value="Палау">Палау</option>

<option value="Панама">Панама</option>

<option value="Папуа-Новая Гвинея">Папуа-Новая Гвинея</option>

<option value="Парагвай">Парагвай</option>

<option value="Перу">Перу</option>

<option value="Питкерн остров">Питкерн остров</option>

<option value="Польша">Польша</option>

<option value="Португалия">Португалия</option>

<option value="Пуэрто-Рико">Пуэрто-Рико</option>

<option value="Реюньон">Реюньон</option>

<option value="<\>Российская Федерация"><\>Российская Федерация</option>

<option value="Руанда">Руанда</option>

<option value="Румыния">Румыния</option>

<option value="Сальвадор">Сальвадор</option>

<option value="Самоа">Самоа</option>

<option value="Сан-Марино">Сан-Марино</option>

<option value="Сан-Томе и Принсипи">Сан-Томе и Принсипи</option>

<option value="Саудовская Аравия">Саудовская Аравия</option>

<option value="Св.Елены остров">Св.Елены остров</option>

<option value="Свазиленд">Свазиленд</option>

<option value="Свалбард и Жан Майен о-ва">Свалбард и Жан Майен о-ва</option>

<option value="Сейшелы">Сейшелы</option>

<option value="Сенегал">Сенегал</option>

<option value="Сент-Винсент и Гренадины">Сент-Винсент и Гренадины</option>

<option value="Сент-Китс и Невис">Сент-Китс и Невис</option>

<option value="Сент-люсия">Сент-люсия</option>

<option value="Сербия и Черногория">Сербия и Черногория</option>

<option value="Сингапур">Сингапур</option>

<option value="Сирия">Сирия</option>

<option value="Словакия">Словакия</option>

<option value="Словения">Словения</option>

<option value="Соединенные Штаты Америки (США)">Соединенные Штаты Америки (США)</option>

<option value="Соломоновы острова">Соломоновы острова</option>

<option value="Сомали">Сомали</option>

<option value="Судан">Судан</option>

<option value="Суринам">Суринам</option>

<option value="Сьерра-Леоне">Сьерра-Леоне</option>

<option value="Таджикистан">Таджикистан</option>

<option value="Таиланд">Таиланд</option>

<option value="Тайвань">Тайвань</option>

<option value="Танзания">Танзания</option>

<option value="Тимор Восточный">Тимор Восточный</option>

<option value="Того">Того</option>

<option value="Токелау">Токелау</option>

<option value="Тонга">Тонга</option>

<option value="Тринидад и Тобаго">Тринидад и Тобаго</option>

<option value="Тувалу">Тувалу</option>

<option value="Тунис">Тунис</option>

<option value="Туркмения">Туркмения</option>

<option value="Турция">Турция</option>

<option value="Уганда">Уганда</option>

<option value="Узбекистан">Узбекистан</option>

<option value="Украина">Украина</option>

<option value="Уоллис острова">Уоллис острова</option>

<option value="Уругвай">Уругвай</option>

<option value="Фарое острова">Фарое острова</option>

<option value="Фиджи">Фиджи</option>

<option value="Филиппины">Филиппины</option>

<option value="Финляндия">Финляндия</option>

<option value="Фолклендские острова">Фолклендские острова</option>

<option value="Франция">Франция</option>

<option value="Французская Гваделупа">Французская Гваделупа</option>

<option value="Французская Гвинея">Французская Гвинея</option>

<option value="Французская Полинезия">Французская Полинезия</option>

<option value="Херд и Мкдональдовы острова">Херд и Мкдональдовы острова</option>

<option value="Хорватия">Хорватия</option>

<option value="Центрально-Африканская Республика">Центрально-Африканская Республика</option>

<option value="Чад">Чад</option>

<option value="Чехия">Чехия</option>

<option value="Чехословакия">Чехословакия</option>

<option value="Чили">Чили</option>

<option value="Швейцария">Швейцария</option>

<option value="Швеция">Швеция</option>

<option value="Шри-Ланка">Шри-Ланка</option>

<option value="Эквадор">Эквадор</option>

<option value="Экваториальная Гвинея">Экваториальная Гвинея</option>

<option value="Эстония">Эстония</option>

<option value="Эфиопия">Эфиопия</option>

<option value="Южно-Африканская Республика">Южно-Африканская Республика</option>

<option value="Ямайка">Ямайка</option>

<option value="Япония">Япония</option>

    </select>
  </td>
</tr>

<tr>
  <td colspan="2" >
  Пожалуйста укажите какого рода информация вас интересует:

<sup><strong>*</strong></sup>
</br>
  <textarea name="req_info" class=ta wrap=soft cols="60" rows="8"></textarea>
  </td>
</tr>


  <tr>
    <td colSpan="4">

<script language="JavaScript" type="text/javascript">
<!--
document.write ('<' + 'input type="hidden" name="protected_field" value="" />');
-->

</script>

<table cellSpacing="0" cellPadding="0" border="0">
<tr>
    <td>Введите код:</td>
    <td>
        <script language="JavaScript" type="text/javascript">
			{literal}
            var rndseed = new String(Math.random()); rndseed = rndseed.substring(2,11);
            var hex = "0123456789abcdef";
            var captchaSID = '';
            for (var i = 0 ; i < 32; i++) {
                var pos = Math.floor(Math.random() * 16);
                captchaSID += hex.substr(pos, 1);
            }
			captchaSID = captchaSID.substr(5,4);
            document.write ('<img src="/modules/captcha/captcha.php?sid=' + captchaSID + '" />');
			document.write ('<input type="hidden" id="sid" name="sid" value="' + captchaSID + '" />');
			{/literal}
        </script>
    </td>
    <td>&nbsp;<input type="text" class="txt" id="captcha" name="captcha" size="4" value="" maxlength="4"></td>
</tr>

</table>
</td>
  </tr>
</table>

<p><sub>* Обязательные поля</sub></p>

<br>

<input type="hidden" name="send_request" value="ok">
<input type="button" class=btn value="  Отправить  " onClick="validate_form(this); return false;">
<input type="reset" class=btn value="  Очистить поля  ">
</form>


  </TD>

</TR>
</TBODY>
</TABLE>

-->
</noscript> 
