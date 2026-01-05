import type React from "react"
import { useEffect, useState } from "react"
import { baseUrl } from "../utils/config"

export interface AllProps {
    setResult: Function
}

const DEFAULT_STATUS = "RUNNING"
const ERR_MSG = "<br /><b>Fatal error</b>:  Maximum execution time of 90 seconds exceeded in <b>/data/web/virtuals/315069/virtual/www/bruteforcer-api/lib/bruteforce.php</b> on line <b>21</b><br />"

export const ComputeAll : React.FC<AllProps> = ({setResult}) => {
    const [status, setStatus] = useState(DEFAULT_STATUS)
    const [count, setCount] = useState(1)

    // const poll = async () => {  // Chat: upraveno
    //     setCount(prev => prev + 1)

    //     const res = await fetch(baseUrl + "bruteforceAll.php")
    //     const data = await res.text()

    //     if (data === "DONE") {
    //         setStatus("DONE")
    //         setResult("Hotovo, .txt si stahnete zde")
    //     }
    //     else if (data != ERR_MSG) {
    //         setResult("CHYBA: " + data)
    //         console.log(data)
    //         console.log(ERR_MSG)
    //         setStatus("DONE_WITH_ERRORS")
    //     }
    // }

    // useEffect(() => {   
    //     if (status === "RUNNING") {
    //         const id = setInterval(poll, 1000)  // Chat
    //         return () => clearInterval(id)  // Chat
    //     }
    // }, [status])



    const handleClick = async () => {
        alert("TATO FCE TRVA DLOUHO")
        setResult("Nacitani, toto bude trvat dlouho....")
        setStatus(DEFAULT_STATUS)
        setCount(0);
        while (status !== "DONE") {
            setCount((prev) => prev + 1);
            setResult("Nacitani: Dotazovani se na API (Pocet pokusu: " + count + ")")
            try {
                const res = await fetch(baseUrl + "bruteforceAll.php")
                const data = await res.text()
                console.log(data)
                if (data === "DONE") {
                    setStatus("DONE")
                    setResult("Hotovo, .txt si stahnete zde")
                }
                // else if (data != ERR_MSG) {
                //     setResult("CHYBA: " + data)
                //     console.log(data)
                //     console.log(ERR_MSG)
                //     setStatus("DONE_WITH_ERRORS")
                //     break;
                // }

            } catch (error) {
                setResult("CHYBA - " + error)
            }        
        }


    }

    return (
        <>
        <button onClick={handleClick}>Odhashovat Vse</button>
        {status === "DONE" && (
            <a
                href="https://www.junglediff.cz/bruteforcer-api/jsons/all.txt"
                download
            >
                Stáhnout
            </a>
        )}
        </>
    )
}

export default ComputeAll