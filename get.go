package main

import (
	"fmt"
	"io/ioutil"
	// "log"
	"net/http"
	"encoding/json"
	// "os"
	// "os/exec"
)
type Auth struct{
	// email string
	// name string
	Active bool
  Iden string
	Created float32
	Modified float32
	Email string
	Email_normalized string
	Name string
	Image_url string
	Max_upload_size int32
	Referred_count int32
}
func main() {
	url := "https://api.pushbullet.com/v2/users/me"

	req, _ := http.NewRequest("GET", url, nil)

	req.Header.Add("access-token", "o.4tkwSdUgj0vgLqyeTftp4mocy3icir9u")

	res, _ := http.DefaultClient.Do(req)

	defer res.Body.Close()
	body, _ := ioutil.ReadAll(res.Body)

	// fmt.Println(res)
	// fmt.Println(string(body))
	// res, err := http.Get("https://api.github.com/")
	// if err != nil {
	// 	log.Fatal(err)
	// }
	// robots, err := ioutil.ReadAll(res.Body)
	// res.Body.Close()
	// if err != nil {
	// 	log.Fatal(err)
	// }
	// fmt.Printf("%s", robots)
	// cmd := exec.Command(os.Args[1], os.Args[2:]...)
	// cmd.Stdin = os.Stdin
	// cmd.Stdout = os.Stdout
	// cmd.Stderr = os.Stderr
	// output := cmd.Run()
	// bytes := json.Marshal(output)
	// fmt.Println(string(body))
	var auth Auth
	json.Unmarshal([]byte(string(body)), &auth)
	// fmt.Printf("Active: %s",auth.active)
	// fmt.Println()
	fmt.Println(auth.Image_url)

}
