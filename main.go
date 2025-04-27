package main

import (
	"fmt"
	"net/http"

	"github.com/a-h/templ"
)

func main() {
	site := Site("✨ Femboy Club 2025 ✨")

	http.Handle("/", templ.Handler(site))
	fmt.Println("Server running on http://localhost:8080")

	fs := http.FileServer(http.Dir("./static"))
	http.Handle("/static/", http.StripPrefix("/static/", fs))

	http.ListenAndServe(":8080", nil)
}
