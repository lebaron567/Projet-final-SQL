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
	fmt.Println("Serveur start at : http://localhost:8080/home")
	http.ListenAndServe(":8080", nil)
}

func Home(w http.ResponseWriter, r *http.Request) {
		http.Redirect(w, r, "/home", http.StatusFound)
	}
