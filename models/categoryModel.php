<?php

  class categoryModel {
    public function __construct()
    { }

    public function getListOfCategorysByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM categories
                        WHERE helpdesk IN(:helpdesk)");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function removeCategoryById($id) {
      $database = new Database();
      $database->query("DELETE FROM categories WHERE id=:id");
      $database->bind(':id', $id);
      $database->execute();
      return true;
    }

    public function upsertCategory($categoryobject) {
      isset($categoryobject->id) ? $this->modifyCategory($categoryobject) : $this->addCategory($categoryobject);
    }

    public function addCategory($categoryobject) {
      $database = new Database();
      $database->query("INSERT INTO categories (categoryName, helpdesk)
                        VALUES (:categoryName, :helpdesk)
                        ");
      $database->bind(':categoryName', $categoryobject->categoryName);
      $database->bind(':helpdesk', $categoryobject->helpdesk);
      $database->execute();
      return $database->lastInsertId();
    }

    public function modifyCategory($categoryobject) {
      $database = new Database();
      $database->query("UPDATE categories
                        SET categories.categoryName = :categoryName,
                            categories.helpdesk = :helpdesk
                        WHERE categories.id = :id
                        ");
      $database->bind(':id', $categoryobject->id);
      $database->bind(':categoryName', $categoryobject->categoryName);
      $database->bind(':helpdesk', $categoryobject->helpdesk);
      $database->execute();
      return $database->lastInsertId();
    }

    public function getCategoryById($id) {
      $database = new Database();
      $database->query("SELECT * FROM categories
                        WHERE id=:id");
      $database->bind(':id', $id);
      $result = $database->single();
      return $result;
    }

}
