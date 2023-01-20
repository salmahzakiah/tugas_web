<?php
class Product
{
    public $id;
    public $judul_buku;
    public $pengarang;
    public $sinopsis;

    private $conn;
    private $table = "tbl_buku";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    function add()
    {
        $query = "INSERT INTO
                " . $this->table . "
            SET
               id=:id, judul_buku=:judul_buku, pengarang=:pengarang, sinopsis=:sinopsis";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('judul_buku', $this->judul_buku);
        $stmt->bindParam('pengarang', $this->pengaranf);
        $stmt->bindParam('sinopsis', $this->sinopsis);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function fetch()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function get()
    {
        $query = "SELECT * FROM " . $this->table . " p          
                WHERE
                    p.id = ?
                LIMIT
                0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $product['id'];
        $this->judul_buku = $product['judul_buku'];
        $this->pengarang = $product['pengarang'];
        $this->sinopsis = $product['sinopsis'];
    }

    function update()
    {
        $query = "UPDATE
                " . $this->table . "
            SET
            judul_buku = :judul_buku,
            pengarang = :pengarang,
            sinopsis = :sinopsis
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam('id', $this->id);
        $stmt->bindParam('judul_buku', $this->judul_buku);
        $stmt->bindParam('pengarang', $this->pengarang);
        $stmt->bindParam('sinopsis', $this->sinopsis);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
