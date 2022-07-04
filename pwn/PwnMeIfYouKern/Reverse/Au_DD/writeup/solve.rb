byte_in_linked_list = [76, 17, 78, 75, 19, 68, 63, 76, 17, 83, 84, 63, 17, 78, 63, 77, 19, 77, 16, 82, 89]


flag = ""

byte_in_linked_list.each do |byte|
    flag+= (byte+32).chr
end

puts "Flag: #{flag}"