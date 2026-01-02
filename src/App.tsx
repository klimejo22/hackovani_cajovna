import { useState } from 'react'
import { baseUrl } from './utils/config'

function App() {
  const [hash, setHash] = useState('')
  const [result, setResult] = useState('')

  
  const handleCheckHash = async () => {
    if (!hash) {
      setResult('Zadej hash!')
      return
    }
    
    console.log("Hash: " + hash)
    const res = await fetch(baseUrl + "bruteforceOne.php", {
      method: "POST",
      headers: {"Content-Type": "application/json"},
      body: JSON.stringify({ hash: hash })
    })

    const data = await res.text();
    setResult(data);
  }

  return (
    <>
      <h1>Hash na String</h1>
      <input
        type="text"
        placeholder="Zadej hash"
        value={hash}
        onChange={(e) => setHash(e.target.value)}
      />
      <button onClick={handleCheckHash}>Zkontrolovat</button>
      <div>Vysledek je: {result}</div>
    </>
  )
}

export default App
