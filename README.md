# loop_alphabet
ExpressionEngine 2 plugin


Use as follows:
```
    {exp:loop_alphabet range="b-g" default_range="a-d"}
        Iteration number {alp_index}, index letter is {alp_index_letter}
    {/exp:loop_alphabet}
```
    
Use `parse="inward"` if you have other loop inside of `{exp:loop_alphabet}`
    
    Default value of parameters: 
        "range": "a-z"
        "default_range": "a-d"
        
In case if parameter "range" is empty/not defined or invalid then value of parameter "default_range" will be used.

In case if both parameters are not empty and incorrect then parameter "range" will have value 'a-z'