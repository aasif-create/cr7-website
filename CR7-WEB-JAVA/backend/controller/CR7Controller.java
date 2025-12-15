package com.cr7.controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class CR7Controller {

    @GetMapping("/cr7")
    public String cr7Info() {
        return "Cristiano Ronaldo - GOAT of Football";
    }
}
