package back

import (
	"database/sql"
	"log"

	_ "github.com/mattn/go-sqlite3"
)

func OpenBDD() *sql.DB {
	database, bdderr := sql.Open("sqlite3", "./BDD.db")
	if bdderr != nil {
		log.Fatal(bdderr.Error())
	}
	return database
}

func InitBDD() {
	database := OpenBDD()
	defer database.Close()
	bdd := `
		CREATE TABLE IF NOT EXISTS "employees" (
			"id_employee" INTEGER NOT NULL UNIQUE,
			"employee_name" VARCHAR(30) NOT NULL, 
			"employee_firstname" VARCHAR(30) NOT NULL, 
			"employee_hourly_rate" REAL NOT NULL,
			PRIMARY KEY("id_employee" 	AUTOINCREMENT)
		);
	`
	_, bdderr := database.Exec(bdd)
	if bdderr != nil {
		log.Fatal(bdderr.Error())
	}
}
