    <form method="post" action="javascript: return false;" name="categories">
    <div class="widget_tableDiv">
    <table border="0" cellpadding="0" cellspacing="0" class="content" id="myTable">
      <thead>
        <tr>
          <td>{lang cnt_action}</td>
          <td>{lang cnt_name}</td>
          <td>{lang cnt_published}</td>
          <td>{lang cnt_lang}</td>
          <td>{lang cnt_user}</td>
          <td>{lang cnt_description}</td>
          <td>{lang cnt_created}</td>
        </tr>
      </thead>
      <tbody class="scrollingContent">
      {$category_row}
      </tbody>
    </table>
    </div>
    </form>
    <script type="text/javascript">
      initTableWidget('myTable',"100%","480",Array(false,'S',false,'S','S','S','D'));
    </script>
