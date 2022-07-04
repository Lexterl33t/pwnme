use ascii_converter::*;
use std::env;
use std::process;

fn valid_code(code: &str) -> bool {
    let flag: [u32; 12] = [114, 234, 460, 928, 1520, 1568, 7360, 12160, 25344, 24576, 49152, 221184];
    let code_ascii = string_to_decimals(code).unwrap();
    for (i, byte) in flag.iter().enumerate() {
        let displ = *byte >> i as u32;
        if displ != code_ascii[i].into() {
            return false;
        }
    }
    return true;
}


fn print_flag() {
    let flag: [u32; 12] = [114, 234, 460, 928, 1520, 1568, 7360, 12160, 25344, 24576, 49152, 221184];
    for (i, byte) in flag.iter().enumerate() {
        let displ = *byte >> i as u32;
        print!("{}", char::from_u32(displ).unwrap());
    }
}


fn main() {

    let args: Vec<String> = env::args().collect();
    if args.len() != 2 {
        println!("Usage: {} <password>", args[0]);
        process::exit(1);
    }

    let password: &str = &args[1];
    if password.chars().count() == 12 {
        if valid_code(&password) {
            print!("Congratulation valid this flag: ");
            print_flag();
        } else {
            println!("Incorrect flag !! Try Again");
        }
    } else {
        println!("Incorrect size password !!");
        process::exit(1);
    }
}
