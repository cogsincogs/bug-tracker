<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dbh.class.php');

class OrgController extends Dbh {

    // Add an organisation into the orgs table in the database
    public function setOrganisation($name, $ownerID, $orgID){
        $sql = "INSERT INTO orgs (name, ownerID, orgID) VALUES (:name, :ownerID, :orgID);";
        $stmt = $this->connect()->prepare($sql);
        try {
            $stmt->execute([
                'name' => $name,
                'ownerID' => $ownerID,
                'orgID' => $orgID
            ]);
        } catch (PDOException $e) {
            die("PDO Error: " . $e->getMessage());
        }
    }

    private function deleteResponses($orgID) {
        $sql = "DELETE FROM responses WHERE orgID = :orgID";
        $stmt = $this->connect()->prepare($sql);
        try {
            $stmt->execute([
                'orgID' => $orgID
            ]);
        } catch (PDOException $e) {
            die("PDO Error: " . $e->getMessage());
        }
    }

    private function deleteTickets($orgID) {
        $this->deleteResponses($orgID);
        $sql = "DELETE FROM tickets WHERE orgID = :orgID";
        $stmt = $this->connect()->prepare($sql);
        try {
            $stmt->execute([
                'orgID' => $orgID
            ]);
        } catch (PDOException $e) {
            die("PDO Error: " . $e->getMessage());
        }
    }

    private function deleteProjects($orgID) {
        $this->deleteTickets($orgID);
        $sql = "DELETE FROM projects WHERE orgID = :orgID";
        $stmt = $this->connect()->prepare($sql);
        try {
            $stmt->execute([
                'orgID' => $orgID
            ]);
        } catch (PDOException $e) {
            die("PDO Error: " . $e->getMessage());
        }
    }

    public function deleteOrganisation($orgID) {
        $this->deleteProjects($orgID);
        $sql = "DELETE FROM orgs WHERE orgID = :orgID";
        $stmt = $this->connect()->prepare($sql);
        try {
            $stmt->execute([
                'orgID' => $orgID
            ]);
        } catch (PDOException $e) {
            die("PDO Error: " . $e->getMessage());
        }
    }

    // Returns an associative array of the organisations owned by $ownerID
    public function getOrganisations($ownerID) {
        $sql = "SELECT * FROM orgs WHERE ownerID = '$ownerID'";
        $stmt = $this->connect()->prepare($sql);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die($e);
        }
        return $stmt->fetchAll();
    }

    // Returns an organisation by its 16-character alphanumeric ID
    public function getOrganisationByID($id) {
        $sql = "SELECT * FROM orgs WHERE orgID = '$id'";
        $stmt = $this->connect()->prepare($sql);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            die($e);
        }
        return $stmt->fetch();
    }
}