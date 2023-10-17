package main

import (
	"fmt"
	"net/http"
	"text/template"
)

var home = template.Must(template.ParseFiles("template/home.html"))

func main() {
	http.HandleFunc("/home", Home)
	fs := http.FileServer(http.Dir("assets/"))
	http.Handle("/assets/", http.StripPrefix("/assets/", fs))
	fmt.Println("Serveur start at : http://localhost:8000/home")
	http.ListenAndServe(":8000", nil)
}

func Home(w http.ResponseWriter, r *http.Request) {
		err := home.Execute(w, nil)
		if err != nil {
			http.Error(w, err.Error(), http.StatusInternalServerError)
		}
	}
