<?php
	class Classkategori{
		public function create($kategori_buku){
			include 'koneksi.php';
			$sql = "insert into tbl_kategori(kategori_buku) values(?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('s', $kategori_buku);
			$query = $stmt->execute();
			$stmt->close();
			$conn->close();
			return $query;
		}

		public function readbyid($id_kategori_buku){
			include 'koneksi.php';
			$sql = "select * from tbl_kategori where id_kategori_buku ='".$id_kategori_buku."'";
			$query = $conn->query($sql);
			$conn->close();
			return $query;
		}

		public function readAll(){
			include 'koneksi.php';
			$sql = "select * from tbl_kategori";
			$query = $conn->query($sql);
			$conn->close();
			return $query;
		}
		public function updatebyid($id_kategori_buku, $kategori_buku){
			include 'koneksi.php';
			$sql = "update tbl_kategori set kategori_buku = ? where id_kategori_buku = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('si', $kategori_buku, $id_kategori_buku);
			$query = $stmt->execute();
			$stmt->close();
			$conn->close();
			return $query;
		}

		public function deletebyid($id_kategori_buku){
			include 'koneksi.php';
			$sql = "delete from tbl_kategori where id_kategori_buku = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param('i', $id_kategori_buku);
			$query = $stmt->execute();
			$stmt->close();
			$conn->close();
			return $query;
		}
	}
?>