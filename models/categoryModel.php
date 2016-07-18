<?php

  class categoryModel {

    private $_startrange = null;
    private $_endrangerange = null;
    private $_helpdesks = null;

    public function __construct()
    {
      // populate custom report values
      $this->_startrange = isset($_SESSION['customReportsRangeStart']) ? $_SESSION['customReportsRangeStart'] : date('Y-m-01');
      $this->_endrange = isset($_SESSION['customReportsRangeEnd']) ? $_SESSION['customReportsRangeEnd'] : date('Y-m-t');
      $this->_helpdesks = isset($_SESSION['customReportsHelpdesks']) ? $_SESSION['customReportsHelpdesks'] : null ;
    }

    public function getListOfCategorysByHelpdesk($helpdeskid) {
      $database = new Database();
      $database->query("SELECT * FROM categories
                        WHERE helpdesk IN(:helpdesk)");
      $database->bind(":helpdesk", $helpdeskid);
      $results = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      return $results;
    }

    public function getListOfCategorys() {
      $database = new Database();
      $database->query("SELECT categories.*, helpdesks.helpdesk_name FROM categories
                        JOIN helpdesks ON categories.helpdesk = helpdesks.id
        ORDER BY helpdesk");
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

    public function countCategoryTotals($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;

      $database = new Database();
      $database->query("SELECT categories.categoryName, count(calls.callid) AS Totals FROM calls
                        JOIN categories ON calls.category=categories.id
                        WHERE calls.status = 2
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        GROUP BY calls.category
                        ORDER BY Totals");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $result = $database->resultset();
      if ($database->rowCount() === 0) { return null;}
      // else populate object with db results
      return $result;
    }

    public function topCategory($scope = null) {
      isset($scope) ? $helpdesks = $scope : $helpdesks = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20"; // fudge for all helpdesks should be count of active helpdesks (//TODO FIX THIS)
      $helpdesks = isset($this->_helpdesks) ? $this->_helpdesks : $helpdesks;
      $database = new Database();
      $database->query("SELECT categories.categoryName, count(calls.category) as topCategory
                        FROM calls
                        JOIN categories ON calls.category = categories.id
                        WHERE calls.status = 2
                        AND FIND_IN_SET(calls.helpdesk, :scope)
                        AND calls.closed BETWEEN :startrange AND :endrange
                        GROUP BY calls.category
                        ORDER BY topCategory DESC
                        ");
      $database->bind(':startrange', $this->_startrange);
      $database->bind(':endrange', $this->_endrange);
      $database->bind(':scope', $helpdesks);
      $results = $database->single();
      if ($database->rowCount() ===0) { return null; }
      return $results;
    }


}
