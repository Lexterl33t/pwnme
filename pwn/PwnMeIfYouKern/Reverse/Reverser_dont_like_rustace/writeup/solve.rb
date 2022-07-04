d = [114, 234, 460, 928, 1520, 1568, 7360, 12160, 25344, 24576, 49152, 221184]

d.map.with_index do |byte, i|
    print (byte >> i).chr
end