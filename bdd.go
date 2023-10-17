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
	
	
	`
	_, bdderr := database.Exec(bdd)
	if bdderr != nil {
		log.Fatal(bdderr.Error())
	}
}
