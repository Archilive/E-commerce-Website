<?php
  function UserItem(int $id, string $name, string $role): string {
    return <<<HTML
    <li class="articleWrapper">
      <span>$name | $role | </span>
      <form action="" method="post">
        <input type="hidden" name="id" value="$id">
        <input type="hidden" name="user">
        <input class="but" type="submit" value="del">
      </form>
      <a href="/account.php?id=$id"><button class="finaliser">edit</button></a>
    </li>
    HTML;
  }
  function ArticleItem(int $id, string $name): string {
    return <<<HTML
    <li class="articleWrapper">
      <span>$name</span>
      <form action="" method="post">
        <input type="hidden" name="id" value="$id">
        <input type="hidden" name="article">
        <input class="but" type="submit" value="del">
      </form>
      <a href="/detail.php?id=$id"><button class="finaliser">edit</button></a>
    </li>
    HTML;
  }
?>