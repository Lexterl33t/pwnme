package main

import (
	"crypto/aes"
	"crypto/md5"
	"encoding/hex"
	"fmt"
	"log"
	"net/http"
	"os"
	"path/filepath"
	"runtime"
	"strings"

	"github.com/forgoer/openssl"
	"github.com/gin-gonic/gin"
)

type PostForm struct {
	Code string `json:"code"`
}

func GenValidCode() string {
	key := []byte{148, 136, 83, 127, 148, 81, 141, 83, 127, 81, 147, 127, 141, 143, 142, 83, 153, 127}
	for i, bt := range key {
		key[i] = bt - 32
	}

	return string(key)
}

func KeyToMd5(text string) string {
	hash := md5.Sum([]byte(text))
	return hex.EncodeToString(hash[:])
}

func GetAESKey() string {
	validCode := []byte(GenValidCode())
	for i, bt := range validCode {
		validCode[i] = bt ^ byte(i)
	}

	return KeyToMd5(string(validCode))
}

func DecryptAES(key []byte, text string) (string, error) {
	ciphertext, _ := hex.DecodeString(text)

	c, err := aes.NewCipher(key)
	if err != nil {
		return "", err
	}
	pt := make([]byte, len(ciphertext))
	c.Decrypt(pt, ciphertext)

	s := string(pt)
	return s, nil
}

func IsValidCode(code string) bool {
	aes_key := GetAESKey()

	decoded_str, _ := hex.DecodeString("59E2267F61917A7832D3608F6DDB2C6146E68ABBE82D0904CE10FE27BEBE4A54")

	dst, err := openssl.AesECBDecrypt(decoded_str, []byte(aes_key), openssl.PKCS7_PADDING)
	if err != nil {
		fmt.Println(err)
		return false
	}

	if code == string(dst) {
		return true
	} else {
		return false
	}
}

func BasePath() string {
	path, err := os.Executable()
	if err != nil {
		log.Fatalf(err.Error())
	}

	if runtime.GOOS == "windows" {
		return filepath.Dir(path) + "\\views\\"
	} else {
		return filepath.Dir(path) + "/views/"
	}
}

func LoginPage(ctx *gin.Context) {
	ctx.HTML(http.StatusOK, "login.tmpl", gin.H{
		"title": "Coffre fort",
	})
}

func VerifyCode(ctx *gin.Context) {
	code := strings.TrimSpace(ctx.PostForm("code"))
	if code == "" {
		ctx.JSON(200, gin.H{
			"error":   true,
			"message": "Veuillez saisir le code",
		})
		return
	}

	if IsValidCode(code) == true {
		ctx.JSON(200, gin.H{
			"error":   false,
			"message": "good",
		})
		return
	} else {
		ctx.JSON(200, gin.H{
			"error":   true,
			"message": "Mauvais flag ! N'abandonne pas !",
		})
		return
	}

}

func main() {
	r := gin.Default()

	r.LoadHTMLGlob(BasePath() + "*.tmpl")
	r.Static("/app", BasePath()+"app")
	r.Static("/lib", BasePath()+"lib")
	r.GET("/", LoginPage)
	r.POST("/verify", VerifyCode)

	r.Run(":8000")
}
