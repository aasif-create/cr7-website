package com.cr7.controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
@RestController
public class LoginController {
    @GetMapping("/login")
    public String login(@RequestParam String user, @RequestParam String pass) {
        if(user.equals("admin") && pass.equals("cr7")) {
            return "Login Success";
        }
        return "Login Failed";
    }
}
