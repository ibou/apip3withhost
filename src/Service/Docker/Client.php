<?php

namespace App\Service\Docker;

class Client extends \App\Service\Docker\Runtime\Client\Client
{
    /**
     * Returns a list of containers. For details on the format, see the
     * [inspect endpoint](#operation/ContainerInspect).
     *
     * Note that it uses a different, smaller representation of a container
     * than inspecting a single container. For example, the list of linked
     * containers is not propagated .
     *
     * @param array $queryParameters {
     *
     * @var bool   $all Return all containers. By default, only running containers are shown.
     * @var int    $limit return this number of most recently created containers, including
     *             non-running ones
     * @var bool   $size return the size of container as fields `SizeRw` and `SizeRootFs`
     * @var string $filters Filters to process on the container list, encoded as JSON (a
     *             `map[string][]string`). For example, `{"status": ["paused"]}` will
     *             only return paused containers.
     *
     * Available filters:
     *
     * - `ancestor`=(`<image-name>[:<tag>]`, `<image id>`, or `<image@digest>`)
     * - `before`=(`<container id>` or `<container name>`)
     * - `expose`=(`<port>[/<proto>]`|`<startport-endport>/[<proto>]`)
     * - `exited=<int>` containers with exit code of `<int>`
     * - `health`=(`starting`|`healthy`|`unhealthy`|`none`)
     * - `id=<ID>` a container's ID
     * - `isolation=`(`default`|`process`|`hyperv`) (Windows daemon only)
     * - `is-task=`(`true`|`false`)
     * - `label=key` or `label="key=value"` of a container label
     * - `name=<name>` a container's name
     * - `network`=(`<network id>` or `<network name>`)
     * - `publish`=(`<port>[/<proto>]`|`<startport-endport>/[<proto>]`)
     * - `since`=(`<container id>` or `<container name>`)
     * - `status=`(`created`|`restarting`|`running`|`removing`|`paused`|`exited`|`dead`)
     * - `volume`=(`<volume name>` or `<mount point destination>`)
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ContainerSummary[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerListBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerListInternalServerErrorException
     */
    public function containerList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerList($queryParameters), $fetch);
    }

    /**
     * @param \App\Service\Docker\Model\ContainersCreatePostBody $body            Container to create
     * @param array                                              $queryParameters {
     *
     * @var string $name Assign the specified name to the container. Must match
     *             `/?[a-zA-Z0-9][a-zA-Z0-9_.-]+`.
     * @var string $platform Platform in the format `os[/arch[/variant]]` used for image lookup.
     *
     * When specified, the daemon checks if the requested image is present
     * in the local image cache with the given OS and Architecture, and
     * otherwise returns a `404` status.
     *
     * If the option is not set, the host's native OS and Architecture are
     * used to look up the image in the image cache. However, if no platform
     * is passed and the given image does exist in the local image cache,
     * but its OS or architecture does not match, the container is created
     * with the available image, and a warning is added to the `Warnings`
     * field in the response, for example;
     *
     * WARNING: The requested image's platform (linux/arm64/v8) does not
     * match the detected host platform (linux/amd64) and no
     * specific platform was requested
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ContainerCreateResponse|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerCreateBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerCreateNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerCreateConflictException
     * @throws \App\Service\Docker\Exception\ContainerCreateInternalServerErrorException
     */
    public function containerCreate(Model\ContainersCreatePostBody $body, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerCreate($body, $queryParameters), $fetch);
    }

    /**
     * Return low-level information about a container.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var bool $size Return the size of container as fields `SizeRw` and `SizeRootFs`
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ContainersIdJsonGetResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerInspectNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerInspectInternalServerErrorException
     */
    public function containerInspect(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerInspect($id, $queryParameters), $fetch);
    }

    /**
     * On Unix systems, this is done by running the `ps` command. This endpoint
     * is not supported on Windows.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $ps_args The arguments to pass to `ps`. For example, `aux`
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ContainersIdTopGetResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerTopNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerTopInternalServerErrorException
     */
    public function containerTop(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerTop($id, $queryParameters), $fetch);
    }

    /**
     * Get `stdout` and `stderr` logs from a container.
     *
     * Note: This endpoint works only for containers with the `json-file` or
     * `journald` logging driver.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var bool   $follow keep connection after returning logs
     * @var bool   $stdout Return logs from `stdout`
     * @var bool   $stderr Return logs from `stderr`
     * @var int    $since Only return logs since this time, as a UNIX timestamp
     * @var int    $until Only return logs before this time, as a UNIX timestamp
     * @var bool   $timestamps Add timestamps to every log line
     * @var string $tail Only return this number of log lines from the end of the logs.
     *             Specify as an integer or `all` to output all log lines.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerLogsNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerLogsInternalServerErrorException
     */
    public function containerLogs(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerLogs($id, $queryParameters), $fetch);
    }

    /**
     * Returns which files in a container's filesystem have been added, deleted,
     * or modified. The `Kind` of modification can be one of:.
     *
     * - `0`: Modified ("C")
     * - `1`: Added ("A")
     * - `2`: Deleted ("D")
     *
     * @param string $id    ID or name of the container
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\FilesystemChange[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerChangesNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerChangesInternalServerErrorException
     */
    public function containerChanges(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerChanges($id), $fetch);
    }

    /**
     * Export the contents of a container as a tarball.
     *
     * @param string $id    ID or name of the container
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerExportNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerExportInternalServerErrorException
     */
    public function containerExport(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerExport($id), $fetch);
    }

    /**
     * This endpoint returns a live stream of a container’s resource usage
     * statistics.
     *
     * The `precpu_stats` is the CPU statistic of the *previous* read, and is
     * used to calculate the CPU usage percentage. It is not an exact copy
     * of the `cpu_stats` field.
     *
     * If either `precpu_stats.online_cpus` or `cpu_stats.online_cpus` is
     * nil then for compatibility with older daemons the length of the
     * corresponding `cpu_usage.percpu_usage` array should be used.
     *
     * On a cgroup v2 host, the following fields are not set
     * `blkio_stats`: all fields other than `io_service_bytes_recursive`
     * `cpu_stats`: `cpu_usage.percpu_usage`
     * `memory_stats`: `max_usage` and `failcnt`
     * Also, `memory_stats.stats` fields are incompatible with cgroup v1.
     *
     * To calculate the values shown by the `stats` command of the docker cli tool
     * the following formulas can be used:
     * used_memory = `memory_stats.usage - memory_stats.stats.cache`
     * available_memory = `memory_stats.limit`
     * Memory usage % = `(used_memory / available_memory) * 100.0`
     * cpu_delta = `cpu_stats.cpu_usage.total_usage - precpu_stats.cpu_usage.total_usage`
     * system_cpu_delta = `cpu_stats.system_cpu_usage - precpu_stats.system_cpu_usage`
     * number_cpus = `lenght(cpu_stats.cpu_usage.percpu_usage)` or `cpu_stats.online_cpus`
     * CPU usage % = `(cpu_delta / system_cpu_delta) * number_cpus * 100.0`
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var bool $stream Stream the output. If false, the stats will be output once and then
     *           it will disconnect.
     * @var bool $one-shot Only get a single stat instead of waiting for 2 cycles. Must be used
     *           with `stream=false`.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerStatsNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerStatsInternalServerErrorException
     */
    public function containerStats(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerStats($id, $queryParameters), $fetch);
    }

    /**
     * Resize the TTY for a container.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var int $h Height of the TTY session in characters
     * @var int $w Width of the TTY session in characters
     *          }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerResizeNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerResizeInternalServerErrorException
     */
    public function containerResize(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerResize($id, $queryParameters), $fetch);
    }

    /**
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $detachKeys Override the key sequence for detaching a container. Format is a
     *             single character `[a-Z]` or `ctrl-<value>` where `<value>` is one
     *             of: `a-z`, `@`, `^`, `[`, `,` or `_`.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerStartNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerStartInternalServerErrorException
     */
    public function containerStart(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerStart($id, $queryParameters), $fetch);
    }

    /**
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $signal Signal to send to the container as an integer or string (e.g. `SIGINT`).
     * @var int    $t Number of seconds to wait before killing the container
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerStopNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerStopInternalServerErrorException
     */
    public function containerStop(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerStop($id, $queryParameters), $fetch);
    }

    /**
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $signal Signal to send to the container as an integer or string (e.g. `SIGINT`).
     * @var int    $t Number of seconds to wait before killing the container
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerRestartNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerRestartInternalServerErrorException
     */
    public function containerRestart(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerRestart($id, $queryParameters), $fetch);
    }

    /**
     * Send a POSIX signal to a container, defaulting to killing to the
     * container.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $signal Signal to send to the container as an integer or string (e.g. `SIGINT`).
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerKillNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerKillConflictException
     * @throws \App\Service\Docker\Exception\ContainerKillInternalServerErrorException
     */
    public function containerKill(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerKill($id, $queryParameters), $fetch);
    }

    /**
     * Change various configuration options of a container without having to
     * recreate it.
     *
     * @param string $id    ID or name of the container
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ContainersIdUpdatePostResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerUpdateNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerUpdateInternalServerErrorException
     */
    public function containerUpdate(string $id, Model\ContainersIdUpdatePostBody $update, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerUpdate($id, $update), $fetch);
    }

    /**
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $name New name for the container
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerRenameNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerRenameConflictException
     * @throws \App\Service\Docker\Exception\ContainerRenameInternalServerErrorException
     */
    public function containerRename(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerRename($id, $queryParameters), $fetch);
    }

    /**
     * Use the freezer cgroup to suspend all processes in a container.
     *
     * Traditionally, when suspending a process the `SIGSTOP` signal is used,
     * which is observable by the process being suspended. With the freezer
     * cgroup the process is unaware, and unable to capture, that it is being
     * suspended, and subsequently resumed.
     *
     * @param string $id    ID or name of the container
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerPauseNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerPauseInternalServerErrorException
     */
    public function containerPause(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerPause($id), $fetch);
    }

    /**
     * Resume a container which has been paused.
     *
     * @param string $id    ID or name of the container
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerUnpauseNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerUnpauseInternalServerErrorException
     */
    public function containerUnpause(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerUnpause($id), $fetch);
    }

    /**
     * Attach to a container to read its output or send it input. You can attach
     * to the same container multiple times and you can reattach to containers
     * that have been detached.
     *
     * Either the `stream` or `logs` parameter must be `true` for this endpoint
     * to do anything.
     *
     * See the [documentation for the `docker attach` command](https://docs.docker.com/engine/reference/commandline/attach/)
     * for more details.
     *
     * ### Hijacking
     *
     * This endpoint hijacks the HTTP connection to transport `stdin`, `stdout`,
     * and `stderr` on the same socket.
     *
     * This is the response from the daemon for an attach request:
     *
     * ```
     * HTTP/1.1 200 OK
     * Content-Type: application/vnd.docker.raw-stream
     *
     * [STREAM]
     * ```
     *
     * After the headers and two new lines, the TCP connection can now be used
     * for raw, bidirectional communication between the client and server.
     *
     * To hint potential proxies about connection hijacking, the Docker client
     * can also optionally send connection upgrade headers.
     *
     * For example, the client sends this request to upgrade the connection:
     *
     * ```
     * POST /containers/16253994b7c4/attach?stream=1&stdout=1 HTTP/1.1
     * Upgrade: tcp
     * Connection: Upgrade
     * ```
     *
     * The Docker daemon will respond with a `101 UPGRADED` response, and will
     * similarly follow with the raw stream:
     *
     * ```
     * HTTP/1.1 101 UPGRADED
     * Content-Type: application/vnd.docker.raw-stream
     * Connection: Upgrade
     * Upgrade: tcp
     *
     * [STREAM]
     * ```
     *
     * ### Stream format
     *
     * When the TTY setting is disabled in [`POST /containers/create`](#operation/ContainerCreate),
     * the HTTP Content-Type header is set to application/vnd.docker.multiplexed-stream
     * and the stream over the hijacked connected is multiplexed to separate out
     * `stdout` and `stderr`. The stream consists of a series of frames, each
     * containing a header and a payload.
     *
     * The header contains the information which the stream writes (`stdout` or
     * `stderr`). It also contains the size of the associated frame encoded in
     * the last four bytes (`uint32`).
     *
     * It is encoded on the first eight bytes like this:
     *
     * ```go
     * header := [8]byte{STREAM_TYPE, 0, 0, 0, SIZE1, SIZE2, SIZE3, SIZE4}
     * ```
     *
     * `STREAM_TYPE` can be:
     *
     * - 0: `stdin` (is written on `stdout`)
     * - 1: `stdout`
     * - 2: `stderr`
     *
     * `SIZE1, SIZE2, SIZE3, SIZE4` are the four bytes of the `uint32` size
     * encoded as big endian.
     *
     * Following the header is the payload, which is the specified number of
     * bytes of `STREAM_TYPE`.
     *
     * The simplest way to implement this protocol is the following:
     *
     * 1. Read 8 bytes.
     * 2. Choose `stdout` or `stderr` depending on the first byte.
     * 3. Extract the frame size from the last four bytes.
     * 4. Read the extracted size and output it on the correct output.
     * 5. Goto 1.
     *
     * ### Stream format when using a TTY
     *
     * When the TTY setting is enabled in [`POST /containers/create`](#operation/ContainerCreate),
     * the stream is not multiplexed. The data exchanged over the hijacked
     * connection is simply the raw data from the process PTY and client's
     * `stdin`.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $detachKeys Override the key sequence for detaching a container.Format is a single
     *             character `[a-Z]` or `ctrl-<value>` where `<value>` is one of: `a-z`,
     *             `@`, `^`, `[`, `,` or `_`.
     * @var bool   $logs Replay previous logs from the container.
     *
     * This is useful for attaching to a container that has started and you
     * want to output everything since the container started.
     *
     * If `stream` is also enabled, once all the previous output has been
     * returned, it will seamlessly transition into streaming current
     * output.
     * @var bool $stream stream attached streams from the time the request was made onwards
     * @var bool $stdin Attach to `stdin`
     * @var bool $stdout Attach to `stdout`
     * @var bool $stderr Attach to `stderr`
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerAttachBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerAttachNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerAttachInternalServerErrorException
     */
    public function containerAttach(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerAttach($id, $queryParameters), $fetch);
    }

    /**
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $detachKeys Override the key sequence for detaching a container.Format is a single
     *             character `[a-Z]` or `ctrl-<value>` where `<value>` is one of: `a-z`,
     *             `@`, `^`, `[`, `,`, or `_`.
     * @var bool   $logs Return logs
     * @var bool   $stream Return stream
     * @var bool   $stdin Attach to `stdin`
     * @var bool   $stdout Attach to `stdout`
     * @var bool   $stderr Attach to `stderr`
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerAttachWebsocketBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerAttachWebsocketNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerAttachWebsocketInternalServerErrorException
     */
    public function containerAttachWebsocket(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerAttachWebsocket($id, $queryParameters), $fetch);
    }

    /**
     * Block until a container stops, then returns the exit code.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $condition Wait until a container state reaches the given condition.
     *
     * Defaults to `not-running` if omitted or empty.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ContainerWaitResponse|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerWaitBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerWaitNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerWaitInternalServerErrorException
     */
    public function containerWait(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerWait($id, $queryParameters), $fetch);
    }

    /**
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var bool $v remove anonymous volumes associated with the container
     * @var bool $force if the container is running, kill it before removing it
     * @var bool $link Remove the specified link associated with the container.
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerDeleteBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerDeleteNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerDeleteConflictException
     * @throws \App\Service\Docker\Exception\ContainerDeleteInternalServerErrorException
     */
    public function containerDelete(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerDelete($id, $queryParameters), $fetch);
    }

    /**
     * Get a tar archive of a resource in the filesystem of container id.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $path Resource in the container’s filesystem to archive.
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerArchiveBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerArchiveNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerArchiveInternalServerErrorException
     */
    public function containerArchive(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerArchive($id, $queryParameters), $fetch);
    }

    /**
     * A response header `X-Docker-Container-Path-Stat` is returned, containing
     * a base64 - encoded JSON object with some filesystem header information
     * about the path.
     *
     * @param string $id              ID or name of the container
     * @param array  $queryParameters {
     *
     * @var string $path Resource in the container’s filesystem to archive.
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerArchiveInfoBadRequestException
     * @throws \App\Service\Docker\Exception\ContainerArchiveInfoNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerArchiveInfoInternalServerErrorException
     */
    public function containerArchiveInfo(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerArchiveInfo($id, $queryParameters), $fetch);
    }

    /**
     * Upload a tar archive to be extracted to a path in the filesystem of container id.
     * `path` parameter is asserted to be a directory. If it exists as a file, 400 error
     * will be returned with message "not a directory".
     *
     * @param string                                            $id              ID or name of the container
     * @param string|resource|\Psr\Http\Message\StreamInterface $inputStream     the input stream must be a tar archive compressed with one of the
     *                                                                           following algorithms: `identity` (no compression), `gzip`, `bzip2`,
     *                                                                           or `xz`
     * @param array                                             $queryParameters {
     *
     * @var string $path path to a directory in the container to extract the archive’s contents into
     * @var string $noOverwriteDirNonDir if `1`, `true`, or `True` then it will be an error if unpacking the
     *             given content would cause an existing directory to be replaced with
     *             a non-directory and vice versa
     * @var string $copyUIDGID If `1`, `true`, then it will copy UID/GID maps to the dest file or
     *             dir
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PutContainerArchiveBadRequestException
     * @throws \App\Service\Docker\Exception\PutContainerArchiveForbiddenException
     * @throws \App\Service\Docker\Exception\PutContainerArchiveNotFoundException
     * @throws \App\Service\Docker\Exception\PutContainerArchiveInternalServerErrorException
     */
    public function putContainerArchive(string $id, $inputStream, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PutContainerArchive($id, $inputStream, $queryParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters Filters to process on the prune list, encoded as JSON (a `map[string][]string`).
     *
     * Available filters:
     * - `until=<timestamp>` Prune containers created before this timestamp. The `<timestamp>` can be Unix timestamps, date formatted timestamps, or Go duration strings (e.g. `10m`, `1h30m`) computed relative to the daemon machine’s time.
     * - `label` (`label=<key>`, `label=<key>=<value>`, `label!=<key>`, or `label!=<key>=<value>`) Prune containers with (or without, in case `label!=...` is used) the specified labels.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ContainersPrunePostResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerPruneInternalServerErrorException
     */
    public function containerPrune(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerPrune($queryParameters), $fetch);
    }

    /**
     * Returns a list of images on the server. Note that it uses a different, smaller representation of an image than inspecting a single image.
     *
     * @param array $queryParameters {
     *
     * @var bool   $all Show all images. Only images from a final layer (no children) are shown by default.
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the images list.
     *
     * Available filters:
     *
     * - `before`=(`<image-name>[:<tag>]`,  `<image id>` or `<image@digest>`)
     * - `dangling=true`
     * - `label=key` or `label="key=value"` of an image label
     * - `reference`=(`<image-name>[:<tag>]`)
     * - `since`=(`<image-name>[:<tag>]`,  `<image id>` or `<image@digest>`)
     * @var bool $shared-size Compute and show shared size as a `SharedSize` field on each image
     * @var bool $digests Show digest information as a `RepoDigests` field on each image.
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ImageSummary[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageListInternalServerErrorException
     */
    public function imageList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageList($queryParameters), $fetch);
    }

    /**
     * Build an image from a tar archive with a `Dockerfile` in it.
     *
     * The `Dockerfile` specifies how the image is built from the tar archive. It is typically in the archive's root, but can be at a different path or have a different name by specifying the `dockerfile` parameter. [See the `Dockerfile` reference for more information](https://docs.docker.com/engine/reference/builder/).
     *
     * The Docker daemon performs a preliminary validation of the `Dockerfile` before starting the build, and returns an error if the syntax is incorrect. After that, each instruction is run one-by-one until the ID of the new image is output.
     *
     * The build is canceled if the client drops the connection by quitting or being killed.
     *
     * @param string|resource|\Psr\Http\Message\StreamInterface $inputStream     a tar archive compressed with one of the following algorithms: identity (no compression), gzip, bzip2, xz
     * @param array                                             $queryParameters {
     *
     * @var string $dockerfile Path within the build context to the `Dockerfile`. This is ignored if `remote` is specified and points to an external `Dockerfile`.
     * @var string $t A name and optional tag to apply to the image in the `name:tag` format. If you omit the tag the default `latest` value is assumed. You can provide several `t` parameters.
     * @var string $extrahosts Extra hosts to add to /etc/hosts
     * @var string $remote A Git repository URI or HTTP/HTTPS context URI. If the URI points to a single text file, the file’s contents are placed into a file called `Dockerfile` and the image is built from that file. If the URI points to a tarball, the file is downloaded by the daemon and the contents therein used as the context for the build. If the URI points to a tarball and the `dockerfile` parameter is also specified, there must be a file with the corresponding path inside the tarball.
     * @var bool   $q suppress verbose build output
     * @var bool   $nocache do not use the cache when building the image
     * @var string $cachefrom JSON array of images used for build cache resolution
     * @var string $pull attempt to pull the image even if an older image exists locally
     * @var bool   $rm remove intermediate containers after a successful build
     * @var bool   $forcerm always remove intermediate containers, even upon failure
     * @var int    $memory set memory limit for build
     * @var int    $memswap Total memory (memory + swap). Set as `-1` to disable swap.
     * @var int    $cpushares CPU shares (relative weight)
     * @var string $cpusetcpus CPUs in which to allow execution (e.g., `0-3`, `0,1`).
     * @var int    $cpuperiod the length of a CPU period in microseconds
     * @var int    $cpuquota microseconds of CPU time that the container can get in a CPU period
     * @var string $buildargs JSON map of string pairs for build-time variables. Users pass these values at build-time. Docker uses the buildargs as the environment context for commands run via the `Dockerfile` RUN instruction, or for variable expansion in other `Dockerfile` instructions. This is not meant for passing secret values.
     *
     * For example, the build arg `FOO=bar` would become `{"FOO":"bar"}` in JSON. This would result in the query parameter `buildargs={"FOO":"bar"}`. Note that `{"FOO":"bar"}` should be URI component encoded.
     *
     * [Read more about the buildargs instruction.](https://docs.docker.com/engine/reference/builder/#arg)
     * @var int    $shmsize Size of `/dev/shm` in bytes. The size must be greater than 0. If omitted the system uses 64MB.
     * @var bool   $squash Squash the resulting images layers into a single layer. *(Experimental release only.)*
     * @var string $labels arbitrary key/value labels to set on the image, as a JSON map of string pairs
     * @var string $networkmode Sets the networking mode for the run commands during build. Supported
     *             standard values are: `bridge`, `host`, `none`, and `container:<name|id>`.
     *             Any other value is taken as a custom network's name or ID to which this
     *             container should connect to.
     * @var string $platform Platform in the format os[/arch[/variant]]
     * @var string $target Target build stage
     * @var string $outputs BuildKit output configuration
     *             }
     *
     * @param array $headerParameters {
     *
     * @var string $Content-type
     * @var string $X-Registry-Config This is a base64-encoded JSON object with auth configurations for multiple registries that a build may refer to.
     *
     * The key is a registry URL, and the value is an auth configuration object, [as described in the authentication section](#section/Authentication). For example:
     *
     * ```
     * {
     * "docker.example.com": {
     * "username": "janedoe",
     * "password": "hunter2"
     * },
     * "https://index.docker.io/v1/": {
     * "username": "mobydock",
     * "password": "conta1n3rize14"
     * }
     * }
     * ```
     *
     * Only the registry domain name (and port if not the default 443) are required. However, for legacy reasons, the Docker Hub registry must be specified with both a `https://` prefix and a `/v1/` suffix even though Docker will prefer to use the v2 registry API.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageBuildBadRequestException
     * @throws \App\Service\Docker\Exception\ImageBuildInternalServerErrorException
     */
    public function imageBuild($inputStream, array $queryParameters = [], array $headerParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageBuild($inputStream, $queryParameters, $headerParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var int    $keep-storage Amount of disk space in bytes to keep for cache
     * @var bool   $all Remove all types of build cache
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the list of build cache objects.
     *
     * Available filters:
     *
     * - `until=<timestamp>` remove cache older than `<timestamp>`. The `<timestamp>` can be Unix timestamps, date formatted timestamps, or Go duration strings (e.g. `10m`, `1h30m`) computed relative to the daemon's local time.
     * - `id=<id>`
     * - `parent=<id>`
     * - `type=<string>`
     * - `description=<string>`
     * - `inuse`
     * - `shared`
     * - `private`
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\BuildPrunePostResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\BuildPruneInternalServerErrorException
     */
    public function buildPrune(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\BuildPrune($queryParameters), $fetch);
    }

    /**
     * Create an image by either pulling it from a registry or importing it.
     *
     * @param string $inputImage      Image content if the value `-` has been specified in fromSrc query parameter
     * @param array  $queryParameters {
     *
     * @var string $fromImage Name of the image to pull. The name may include a tag or digest. This parameter may only be used when pulling an image. The pull is cancelled if the HTTP connection is closed.
     * @var string $fromSrc Source to import. The value may be a URL from which the image can be retrieved or `-` to read the image from the request body. This parameter may only be used when importing an image.
     * @var string $repo Repository name given to an image when it is imported. The repo may include a tag. This parameter may only be used when importing an image.
     * @var string $tag Tag or digest. If empty when pulling an image, this causes all tags for the given image to be pulled.
     * @var string $message set commit message for imported image
     * @var array  $changes Apply `Dockerfile` instructions to the image that is created,
     *             for example: `changes=ENV DEBUG=true`.
     *             Note that `ENV DEBUG=true` should be URI component encoded.
     *
     * Supported `Dockerfile` instructions:
     * `CMD`|`ENTRYPOINT`|`ENV`|`EXPOSE`|`ONBUILD`|`USER`|`VOLUME`|`WORKDIR`
     * @var string $platform Platform in the format os[/arch[/variant]].
     *
     * When used in combination with the `fromImage` option, the daemon checks
     * if the given image is present in the local image cache with the given
     * OS and Architecture, and otherwise attempts to pull the image. If the
     * option is not set, the host's native OS and Architecture are used.
     * If the given image does not exist in the local image cache, the daemon
     * attempts to pull the image with the host's native OS and Architecture.
     * If the given image does exists in the local image cache, but its OS or
     * architecture does not match, a warning is produced.
     *
     * When used with the `fromSrc` option to import an image from an archive,
     * this option sets the platform information for the imported image. If
     * the option is not set, the host's native OS and Architecture are used
     * for the imported image.
     *
     * }
     *
     * @param array $headerParameters {
     *
     * @var string $X-Registry-Auth A base64url-encoded auth configuration.
     *
     * Refer to the [authentication section](#section/Authentication) for
     * details.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageCreateNotFoundException
     * @throws \App\Service\Docker\Exception\ImageCreateInternalServerErrorException
     */
    public function imageCreate(string $inputImage, array $queryParameters = [], array $headerParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageCreate($inputImage, $queryParameters, $headerParameters), $fetch);
    }

    /**
     * Return low-level information about an image.
     *
     * @param string $name  Image name or id
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ImageInspect|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageInspectNotFoundException
     * @throws \App\Service\Docker\Exception\ImageInspectInternalServerErrorException
     */
    public function imageInspect(string $name, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageInspect($name), $fetch);
    }

    /**
     * Return parent layers of an image.
     *
     * @param string $name  Image name or ID
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ImagesNameHistoryGetResponse200Item[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageHistoryNotFoundException
     * @throws \App\Service\Docker\Exception\ImageHistoryInternalServerErrorException
     */
    public function imageHistory(string $name, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageHistory($name), $fetch);
    }

    /**
     * Push an image to a registry.
     *
     * If you wish to push an image on to a private registry, that image must
     * already have a tag which references the registry. For example,
     * `registry.example.com/myimage:latest`.
     *
     * The push is cancelled if the HTTP connection is closed.
     *
     * @param string $name            image name or ID
     * @param array  $queryParameters {
     *
     * @var string $tag The tag to associate with the image on the registry.
     *             }
     *
     * @param array $headerParameters {
     *
     * @var string $X-Registry-Auth A base64url-encoded auth configuration.
     *
     * Refer to the [authentication section](#section/Authentication) for
     * details.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImagePushNotFoundException
     * @throws \App\Service\Docker\Exception\ImagePushInternalServerErrorException
     */
    public function imagePush(string $name, array $queryParameters = [], array $headerParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImagePush($name, $queryParameters, $headerParameters), $fetch);
    }

    /**
     * Tag an image so that it becomes part of a repository.
     *
     * @param string $name            image name or ID to tag
     * @param array  $queryParameters {
     *
     * @var string $repo The repository to tag in. For example, `someuser/someimage`.
     * @var string $tag The name of the new tag.
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageTagBadRequestException
     * @throws \App\Service\Docker\Exception\ImageTagNotFoundException
     * @throws \App\Service\Docker\Exception\ImageTagConflictException
     * @throws \App\Service\Docker\Exception\ImageTagInternalServerErrorException
     */
    public function imageTag(string $name, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageTag($name, $queryParameters), $fetch);
    }

    /**
     * Remove an image, along with any untagged parent images that were
     * referenced by that image.
     *
     * Images can't be removed if they have descendant images, are being
     * used by a running container or are being used by a build.
     *
     * @param string $name            Image name or ID
     * @param array  $queryParameters {
     *
     * @var bool $force Remove the image even if it is being used by stopped containers or has other tags
     * @var bool $noprune Do not delete untagged parent images
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ImageDeleteResponseItem[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageDeleteNotFoundException
     * @throws \App\Service\Docker\Exception\ImageDeleteConflictException
     * @throws \App\Service\Docker\Exception\ImageDeleteInternalServerErrorException
     */
    public function imageDelete(string $name, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageDelete($name, $queryParameters), $fetch);
    }

    /**
     * Search for an image on Docker Hub.
     *
     * @param array $queryParameters {
     *
     * @var string $term Term to search
     * @var int    $limit Maximum number of results to return
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to process on the images list. Available filters:
     *
     * - `is-automated=(true|false)`
     * - `is-official=(true|false)`
     * - `stars=<number>` Matches images that has at least 'number' stars.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ImagesSearchGetResponse200Item[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageSearchInternalServerErrorException
     */
    public function imageSearch(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageSearch($queryParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters Filters to process on the prune list, encoded as JSON (a `map[string][]string`). Available filters:
     *
     * - `dangling=<boolean>` When set to `true` (or `1`), prune only
     * unused *and* untagged images. When set to `false`
     * (or `0`), all unused images are pruned.
     * - `until=<string>` Prune images created before this timestamp. The `<timestamp>` can be Unix timestamps, date formatted timestamps, or Go duration strings (e.g. `10m`, `1h30m`) computed relative to the daemon machine’s time.
     * - `label` (`label=<key>`, `label=<key>=<value>`, `label!=<key>`, or `label!=<key>=<value>`) Prune images with (or without, in case `label!=...` is used) the specified labels.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ImagesPrunePostResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImagePruneInternalServerErrorException
     */
    public function imagePrune(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImagePrune($queryParameters), $fetch);
    }

    /**
     * Validate credentials for a registry and, if available, get an identity
     * token for accessing the registry without password.
     *
     * @param \App\Service\Docker\Model\AuthConfig $authConfig Authentication to check
     * @param string                               $fetch      Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\AuthPostResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SystemAuthUnauthorizedException
     * @throws \App\Service\Docker\Exception\SystemAuthInternalServerErrorException
     */
    public function systemAuth(Model\AuthConfig $authConfig, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SystemAuth($authConfig), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\SystemInfo|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SystemInfoInternalServerErrorException
     */
    public function systemInfo(string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SystemInfo(), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\SystemVersion|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SystemVersionInternalServerErrorException
     */
    public function systemVersion(string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SystemVersion(), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SystemPingInternalServerErrorException
     */
    public function systemPing(string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SystemPing(), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SystemPingHeadInternalServerErrorException
     */
    public function systemPingHead(string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SystemPingHead(), $fetch);
    }

    /**
     * @param \App\Service\Docker\Model\ContainerConfig $containerConfig The container configuration
     * @param array                                     $queryParameters {
     *
     * @var string $container The ID or name of the container to commit
     * @var string $repo Repository name for the created image
     * @var string $tag Tag name for the create image
     * @var string $comment Commit message
     * @var string $author Author of the image (e.g., `John Hannibal Smith <hannibal@a-team.com>`)
     * @var bool   $pause Whether to pause the container before committing
     * @var string $changes `Dockerfile` instructions to apply while committing
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\IdResponse|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageCommitNotFoundException
     * @throws \App\Service\Docker\Exception\ImageCommitInternalServerErrorException
     */
    public function imageCommit(Model\ContainerConfig $containerConfig, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageCommit($containerConfig, $queryParameters), $fetch);
    }

    /**
     * Stream real-time events from the server.
     *
     * Various objects within Docker report events when something happens to them.
     *
     * Containers report these events: `attach`, `commit`, `copy`, `create`, `destroy`, `detach`, `die`, `exec_create`, `exec_detach`, `exec_start`, `exec_die`, `export`, `health_status`, `kill`, `oom`, `pause`, `rename`, `resize`, `restart`, `start`, `stop`, `top`, `unpause`, `update`, and `prune`
     *
     * Images report these events: `delete`, `import`, `load`, `pull`, `push`, `save`, `tag`, `untag`, and `prune`
     *
     * Volumes report these events: `create`, `mount`, `unmount`, `destroy`, and `prune`
     *
     * Networks report these events: `create`, `connect`, `disconnect`, `destroy`, `update`, `remove`, and `prune`
     *
     * The Docker daemon reports these events: `reload`
     *
     * Services report these events: `create`, `update`, and `remove`
     *
     * Nodes report these events: `create`, `update`, and `remove`
     *
     * Secrets report these events: `create`, `update`, and `remove`
     *
     * Configs report these events: `create`, `update`, and `remove`
     *
     * The Builder reports `prune` events
     *
     * @param array $queryParameters {
     *
     * @var string $since show events created since this timestamp then stream new events
     * @var string $until show events created until this timestamp then stop streaming
     * @var string $filters A JSON encoded value of filters (a `map[string][]string`) to process on the event list. Available filters:
     *
     * - `config=<string>` config name or ID
     * - `container=<string>` container name or ID
     * - `daemon=<string>` daemon name or ID
     * - `event=<string>` event type
     * - `image=<string>` image name or ID
     * - `label=<string>` image or container label
     * - `network=<string>` network name or ID
     * - `node=<string>` node ID
     * - `plugin`=<string> plugin name or ID
     * - `scope`=<string> local or swarm
     * - `secret=<string>` secret name or ID
     * - `service=<string>` service name or ID
     * - `type=<string>` object to filter by, one of `container`, `image`, `volume`, `network`, `daemon`, `plugin`, `node`, `service`, `secret` or `config`
     * - `volume=<string>` volume name
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\EventMessage|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SystemEventsBadRequestException
     * @throws \App\Service\Docker\Exception\SystemEventsInternalServerErrorException
     */
    public function systemEvents(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SystemEvents($queryParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var array $type Object types, for which to compute and return data.
     *            }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\SystemDfGetResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SystemDataUsageInternalServerErrorException
     */
    public function systemDataUsage(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SystemDataUsage($queryParameters), $fetch);
    }

    /**
     * Get a tarball containing all images and metadata for a repository.
     *
     * If `name` is a specific name and tag (e.g. `ubuntu:latest`), then only that image (and its parents) are returned. If `name` is an image ID, similarly only that image (and its parents) are returned, but with the exclusion of the `repositories` file in the tarball, as there were no image names referenced.
     *
     * ### Image tarball format
     *
     * An image tarball contains one directory per image layer (named using its long ID), each containing these files:
     *
     * - `VERSION`: currently `1.0` - the file format version
     * - `json`: detailed layer information, similar to `docker inspect layer_id`
     * - `layer.tar`: A tarfile containing the filesystem changes in this layer
     *
     * The `layer.tar` file contains `aufs` style `.wh..wh.aufs` files and directories for storing attribute changes and deletions.
     *
     * If the tarball defines a repository, the tarball should also include a `repositories` file at the root that contains a list of repository and tag names mapped to layer IDs.
     *
     * ```json
     * {
     * "hello-world": {
     * "latest": "565a9d68a73f6706862bfe8409a7f659776d4d60a8d096eb4a3cbce6999cc2a1"
     * }
     * }
     * ```
     *
     * @param string $name  Image name or ID
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageGetInternalServerErrorException
     */
    public function imageGet(string $name, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageGet($name), $fetch);
    }

    /**
     * Get a tarball containing all images and metadata for several image
     * repositories.
     *
     * For each value of the `names` parameter: if it is a specific name and
     * tag (e.g. `ubuntu:latest`), then only that image (and its parents) are
     * returned; if it is an image ID, similarly only that image (and its parents)
     * are returned and there would be no names referenced in the 'repositories'
     * file for this image ID.
     *
     * For details on the format, see the [export image endpoint](#operation/ImageGet).
     *
     * @param array $queryParameters {
     *
     * @var array $names Image names to filter by
     *            }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageGetAllInternalServerErrorException
     */
    public function imageGetAll(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageGetAll($queryParameters), $fetch);
    }

    /**
     * Load a set of images and tags into a repository.
     *
     * For details on the format, see the [export image endpoint](#operation/ImageGet).
     *
     * @param string|resource|\Psr\Http\Message\StreamInterface $imagesTarball   Tar archive containing images
     * @param array                                             $queryParameters {
     *
     * @var bool $quiet Suppress progress details during load.
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ImageLoadInternalServerErrorException
     */
    public function imageLoad($imagesTarball, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ImageLoad($imagesTarball, $queryParameters), $fetch);
    }

    /**
     * Run a command inside a running container.
     *
     * @param string                                             $id         ID or name of container
     * @param \App\Service\Docker\Model\ContainersIdExecPostBody $execConfig Exec configuration
     * @param string                                             $fetch      Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\IdResponse|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ContainerExecNotFoundException
     * @throws \App\Service\Docker\Exception\ContainerExecConflictException
     * @throws \App\Service\Docker\Exception\ContainerExecInternalServerErrorException
     */
    public function containerExec(string $id, Model\ContainersIdExecPostBody $execConfig, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ContainerExec($id, $execConfig), $fetch);
    }

    /**
     * Starts a previously set up exec instance. If detach is true, this endpoint
     * returns immediately after starting the command. Otherwise, it sets up an
     * interactive session with the command.
     *
     * @param string $id    Exec instance ID
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ExecStartNotFoundException
     * @throws \App\Service\Docker\Exception\ExecStartConflictException
     */
    public function execStart(string $id, Model\ExecIdStartPostBody $execStartConfig, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ExecStart($id, $execStartConfig), $fetch);
    }

    /**
     * Resize the TTY session used by an exec instance. This endpoint only works
     * if `tty` was specified as part of creating and starting the exec instance.
     *
     * @param string $id              Exec instance ID
     * @param array  $queryParameters {
     *
     * @var int $h Height of the TTY session in characters
     * @var int $w Width of the TTY session in characters
     *          }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ExecResizeBadRequestException
     * @throws \App\Service\Docker\Exception\ExecResizeNotFoundException
     * @throws \App\Service\Docker\Exception\ExecResizeInternalServerErrorException
     */
    public function execResize(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ExecResize($id, $queryParameters), $fetch);
    }

    /**
     * Return low-level information about an exec instance.
     *
     * @param string $id    Exec instance ID
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ExecIdJsonGetResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ExecInspectNotFoundException
     * @throws \App\Service\Docker\Exception\ExecInspectInternalServerErrorException
     */
    public function execInspect(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ExecInspect($id), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the volumes list. Available filters:
     *
     * - `dangling=<boolean>` When set to `true` (or `1`), returns all
     * volumes that are not in use by a container. When set to `false`
     * (or `0`), only volumes that are in use by one or more
     * containers are returned.
     * - `driver=<volume-driver-name>` Matches volumes based on their driver.
     * - `label=<key>` or `label=<key>:<value>` Matches volumes based on
     * the presence of a `label` alone or a `label` and a value.
     * - `name=<volume-name>` Matches all or part of a volume name.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\VolumeListResponse|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\VolumeListInternalServerErrorException
     */
    public function volumeList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\VolumeList($queryParameters), $fetch);
    }

    /**
     * @param \App\Service\Docker\Model\VolumeCreateOptions $volumeConfig Volume configuration
     * @param string                                        $fetch        Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Volume|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\VolumeCreateInternalServerErrorException
     */
    public function volumeCreate(Model\VolumeCreateOptions $volumeConfig, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\VolumeCreate($volumeConfig), $fetch);
    }

    /**
     * Instruct the driver to remove the volume.
     *
     * @param string $name            Volume name or ID
     * @param array  $queryParameters {
     *
     * @var bool $force Force the removal of the volume
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\VolumeDeleteNotFoundException
     * @throws \App\Service\Docker\Exception\VolumeDeleteConflictException
     * @throws \App\Service\Docker\Exception\VolumeDeleteInternalServerErrorException
     */
    public function volumeDelete(string $name, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\VolumeDelete($name, $queryParameters), $fetch);
    }

    /**
     * @param string $name  Volume name or ID
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Volume|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\VolumeInspectNotFoundException
     * @throws \App\Service\Docker\Exception\VolumeInspectInternalServerErrorException
     */
    public function volumeInspect(string $name, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\VolumeInspect($name), $fetch);
    }

    /**
     * @param string                                       $name            The name or ID of the volume
     * @param \App\Service\Docker\Model\VolumesNamePutBody $body            The spec of the volume to update. Currently, only Availability may
     *                                                                      change. All other fields must remain unchanged.
     * @param array                                        $queryParameters {
     *
     * @var int $version The version number of the volume being updated. This is required to
     *          avoid conflicting writes. Found in the volume's `ClusterVolume`
     *          field.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\VolumeUpdateBadRequestException
     * @throws \App\Service\Docker\Exception\VolumeUpdateNotFoundException
     * @throws \App\Service\Docker\Exception\VolumeUpdateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\VolumeUpdateServiceUnavailableException
     */
    public function volumeUpdate(string $name, Model\VolumesNamePutBody $body, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\VolumeUpdate($name, $body, $queryParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters Filters to process on the prune list, encoded as JSON (a `map[string][]string`).
     *
     * Available filters:
     * - `label` (`label=<key>`, `label=<key>=<value>`, `label!=<key>`, or `label!=<key>=<value>`) Prune volumes with (or without, in case `label!=...` is used) the specified labels.
     * - `all` (`all=true`) - Consider all (local) volumes for pruning and not just anonymous volumes.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\VolumesPrunePostResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\VolumePruneInternalServerErrorException
     */
    public function volumePrune(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\VolumePrune($queryParameters), $fetch);
    }

    /**
     * Returns a list of networks. For details on the format, see the
     * [network inspect endpoint](#operation/NetworkInspect).
     *
     * Note that it uses a different, smaller representation of a network than
     * inspecting a single network. For example, the list of containers attached
     * to the network is not propagated in API versions 1.28 and up.
     *
     * @param array $queryParameters {
     *
     * @var string $filters JSON encoded value of the filters (a `map[string][]string`) to process
     *             on the networks list.
     *
     * Available filters:
     *
     * - `dangling=<boolean>` When set to `true` (or `1`), returns all
     * networks that are not in use by a container. When set to `false`
     * (or `0`), only networks that are in use by one or more
     * containers are returned.
     * - `driver=<driver-name>` Matches a network's driver.
     * - `id=<network-id>` Matches all or part of a network ID.
     * - `label=<key>` or `label=<key>=<value>` of a network label.
     * - `name=<network-name>` Matches all or part of a network name.
     * - `scope=["swarm"|"global"|"local"]` Filters networks by scope (`swarm`, `global`, or `local`).
     * - `type=["custom"|"builtin"]` Filters networks by type. The `custom` keyword returns all user-defined networks.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Network[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NetworkListInternalServerErrorException
     */
    public function networkList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NetworkList($queryParameters), $fetch);
    }

    /**
     * @param string $id    Network ID or name
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NetworkDeleteForbiddenException
     * @throws \App\Service\Docker\Exception\NetworkDeleteNotFoundException
     * @throws \App\Service\Docker\Exception\NetworkDeleteInternalServerErrorException
     */
    public function networkDelete(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NetworkDelete($id), $fetch);
    }

    /**
     * @param string $id              Network ID or name
     * @param array  $queryParameters {
     *
     * @var bool   $verbose Detailed inspect output for troubleshooting
     * @var string $scope Filter the network by scope (swarm, global, or local)
     *             }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Network|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NetworkInspectNotFoundException
     * @throws \App\Service\Docker\Exception\NetworkInspectInternalServerErrorException
     */
    public function networkInspect(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NetworkInspect($id, $queryParameters), $fetch);
    }

    /**
     * @param \App\Service\Docker\Model\NetworksCreatePostBody $networkConfig Network configuration
     * @param string                                           $fetch         Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\NetworksCreatePostResponse201|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NetworkCreateForbiddenException
     * @throws \App\Service\Docker\Exception\NetworkCreateNotFoundException
     * @throws \App\Service\Docker\Exception\NetworkCreateInternalServerErrorException
     */
    public function networkCreate(Model\NetworksCreatePostBody $networkConfig, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NetworkCreate($networkConfig), $fetch);
    }

    /**
     * @param string $id    Network ID or name
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NetworkConnectForbiddenException
     * @throws \App\Service\Docker\Exception\NetworkConnectNotFoundException
     * @throws \App\Service\Docker\Exception\NetworkConnectInternalServerErrorException
     */
    public function networkConnect(string $id, Model\NetworksIdConnectPostBody $container, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NetworkConnect($id, $container), $fetch);
    }

    /**
     * @param string $id    Network ID or name
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NetworkDisconnectForbiddenException
     * @throws \App\Service\Docker\Exception\NetworkDisconnectNotFoundException
     * @throws \App\Service\Docker\Exception\NetworkDisconnectInternalServerErrorException
     */
    public function networkDisconnect(string $id, Model\NetworksIdDisconnectPostBody $container, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NetworkDisconnect($id, $container), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters Filters to process on the prune list, encoded as JSON (a `map[string][]string`).
     *
     * Available filters:
     * - `until=<timestamp>` Prune networks created before this timestamp. The `<timestamp>` can be Unix timestamps, date formatted timestamps, or Go duration strings (e.g. `10m`, `1h30m`) computed relative to the daemon machine’s time.
     * - `label` (`label=<key>`, `label=<key>=<value>`, `label!=<key>`, or `label!=<key>=<value>`) Prune networks with (or without, in case `label!=...` is used) the specified labels.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\NetworksPrunePostResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NetworkPruneInternalServerErrorException
     */
    public function networkPrune(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NetworkPrune($queryParameters), $fetch);
    }

    /**
     * Returns information about installed plugins.
     *
     * @param array $queryParameters {
     *
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the plugin list.
     *
     * Available filters:
     *
     * - `capability=<capability name>`
     * - `enable=<true>|<false>`
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Plugin[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginListInternalServerErrorException
     */
    public function pluginList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginList($queryParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $remote The name of the plugin. The `:latest` tag is optional, and is the
     *             default if omitted.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\PluginPrivilege[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\GetPluginPrivilegesInternalServerErrorException
     */
    public function getPluginPrivileges(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\GetPluginPrivileges($queryParameters), $fetch);
    }

    /**
     * Pulls and installs a plugin. After the plugin is installed, it can be
     * enabled using the [`POST /plugins/{name}/enable` endpoint](#operation/PostPluginsEnable).
     *
     * @param \App\Service\Docker\Model\PluginPrivilege[] $body
     * @param array                                       $queryParameters {
     *
     * @var string $remote Remote reference for plugin to install.
     *
     * The `:latest` tag is optional, and is used as the default if omitted.
     * @var string $name Local name for the pulled plugin.
     *
     * The `:latest` tag is optional, and is used as the default if omitted.
     *
     * }
     *
     * @param array $headerParameters {
     *
     * @var string $X-Registry-Auth A base64url-encoded auth configuration to use when pulling a plugin
     *             from a registry.
     *
     * Refer to the [authentication section](#section/Authentication) for
     * details.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginPullInternalServerErrorException
     */
    public function pluginPull(array $body, array $queryParameters = [], array $headerParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginPull($body, $queryParameters, $headerParameters), $fetch);
    }

    /**
     * @param string $name  The name of the plugin. The `:latest` tag is optional, and is the
     *                      default if omitted.
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Plugin|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginInspectNotFoundException
     * @throws \App\Service\Docker\Exception\PluginInspectInternalServerErrorException
     */
    public function pluginInspect(string $name, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginInspect($name), $fetch);
    }

    /**
     * @param string $name            The name of the plugin. The `:latest` tag is optional, and is the
     *                                default if omitted.
     * @param array  $queryParameters {
     *
     * @var bool $force Disable the plugin before removing. This may result in issues if the
     *           plugin is in use by a container.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Plugin|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginDeleteNotFoundException
     * @throws \App\Service\Docker\Exception\PluginDeleteInternalServerErrorException
     */
    public function pluginDelete(string $name, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginDelete($name, $queryParameters), $fetch);
    }

    /**
     * @param string $name            The name of the plugin. The `:latest` tag is optional, and is the
     *                                default if omitted.
     * @param array  $queryParameters {
     *
     * @var int $timeout Set the HTTP client timeout (in seconds)
     *          }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginEnableNotFoundException
     * @throws \App\Service\Docker\Exception\PluginEnableInternalServerErrorException
     */
    public function pluginEnable(string $name, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginEnable($name, $queryParameters), $fetch);
    }

    /**
     * @param string $name            The name of the plugin. The `:latest` tag is optional, and is the
     *                                default if omitted.
     * @param array  $queryParameters {
     *
     * @var bool $force Force disable a plugin even if still in use.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginDisableNotFoundException
     * @throws \App\Service\Docker\Exception\PluginDisableInternalServerErrorException
     */
    public function pluginDisable(string $name, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginDisable($name, $queryParameters), $fetch);
    }

    /**
     * @param string                                      $name            The name of the plugin. The `:latest` tag is optional, and is the
     *                                                                     default if omitted.
     * @param \App\Service\Docker\Model\PluginPrivilege[] $body
     * @param array                                       $queryParameters {
     *
     * @var string $remote Remote reference to upgrade to.
     *
     * The `:latest` tag is optional, and is used as the default if omitted.
     *
     * }
     *
     * @param array $headerParameters {
     *
     * @var string $X-Registry-Auth A base64url-encoded auth configuration to use when pulling a plugin
     *             from a registry.
     *
     * Refer to the [authentication section](#section/Authentication) for
     * details.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginUpgradeNotFoundException
     * @throws \App\Service\Docker\Exception\PluginUpgradeInternalServerErrorException
     */
    public function pluginUpgrade(string $name, array $body, array $queryParameters = [], array $headerParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginUpgrade($name, $body, $queryParameters, $headerParameters), $fetch);
    }

    /**
     * @param string|resource|\Psr\Http\Message\StreamInterface $tarContext      Path to tar containing plugin rootfs and manifest
     * @param array                                             $queryParameters {
     *
     * @var string $name The name of the plugin. The `:latest` tag is optional, and is the
     *             default if omitted.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginCreateInternalServerErrorException
     */
    public function pluginCreate($tarContext, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginCreate($tarContext, $queryParameters), $fetch);
    }

    /**
     * Push a plugin to the registry.
     *
     * @param string $name  The name of the plugin. The `:latest` tag is optional, and is the
     *                      default if omitted.
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginPushNotFoundException
     * @throws \App\Service\Docker\Exception\PluginPushInternalServerErrorException
     */
    public function pluginPush(string $name, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginPush($name), $fetch);
    }

    /**
     * @param string $name  The name of the plugin. The `:latest` tag is optional, and is the
     *                      default if omitted.
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\PluginSetNotFoundException
     * @throws \App\Service\Docker\Exception\PluginSetInternalServerErrorException
     */
    public function pluginSet(string $name, array $body, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\PluginSet($name, $body), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters Filters to process on the nodes list, encoded as JSON (a `map[string][]string`).
     *
     * Available filters:
     * - `id=<node id>`
     * - `label=<engine label>`
     * - `membership=`(`accepted`|`pending`)`
     * - `name=<node name>`
     * - `node.label=<node label>`
     * - `role=`(`manager`|`worker`)`
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Node[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NodeListInternalServerErrorException
     * @throws \App\Service\Docker\Exception\NodeListServiceUnavailableException
     */
    public function nodeList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NodeList($queryParameters), $fetch);
    }

    /**
     * @param string $id              The ID or name of the node
     * @param array  $queryParameters {
     *
     * @var bool $force Force remove a node from the swarm
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NodeDeleteNotFoundException
     * @throws \App\Service\Docker\Exception\NodeDeleteInternalServerErrorException
     * @throws \App\Service\Docker\Exception\NodeDeleteServiceUnavailableException
     */
    public function nodeDelete(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NodeDelete($id, $queryParameters), $fetch);
    }

    /**
     * @param string $id    The ID or name of the node
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Node|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NodeInspectNotFoundException
     * @throws \App\Service\Docker\Exception\NodeInspectInternalServerErrorException
     * @throws \App\Service\Docker\Exception\NodeInspectServiceUnavailableException
     */
    public function nodeInspect(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NodeInspect($id), $fetch);
    }

    /**
     * @param string $id              The ID of the node
     * @param array  $queryParameters {
     *
     * @var int $version The version number of the node object being updated. This is required
     *          to avoid conflicting writes.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\NodeUpdateBadRequestException
     * @throws \App\Service\Docker\Exception\NodeUpdateNotFoundException
     * @throws \App\Service\Docker\Exception\NodeUpdateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\NodeUpdateServiceUnavailableException
     */
    public function nodeUpdate(string $id, Model\NodeSpec $body, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\NodeUpdate($id, $body, $queryParameters), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Swarm|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SwarmInspectNotFoundException
     * @throws \App\Service\Docker\Exception\SwarmInspectInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SwarmInspectServiceUnavailableException
     */
    public function swarmInspect(string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SwarmInspect(), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SwarmInitBadRequestException
     * @throws \App\Service\Docker\Exception\SwarmInitInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SwarmInitServiceUnavailableException
     */
    public function swarmInit(Model\SwarmInitPostBody $body, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SwarmInit($body), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SwarmJoinBadRequestException
     * @throws \App\Service\Docker\Exception\SwarmJoinInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SwarmJoinServiceUnavailableException
     */
    public function swarmJoin(Model\SwarmJoinPostBody $body, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SwarmJoin($body), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var bool $force Force leave swarm, even if this is the last manager or that it will
     *           break the cluster.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SwarmLeaveInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SwarmLeaveServiceUnavailableException
     */
    public function swarmLeave(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SwarmLeave($queryParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var int  $version The version number of the swarm object being updated. This is
     *           required to avoid conflicting writes.
     * @var bool $rotateWorkerToken rotate the worker join token
     * @var bool $rotateManagerToken rotate the manager join token
     * @var bool $rotateManagerUnlockKey Rotate the manager unlock key.
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SwarmUpdateBadRequestException
     * @throws \App\Service\Docker\Exception\SwarmUpdateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SwarmUpdateServiceUnavailableException
     */
    public function swarmUpdate(Model\SwarmSpec $body, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SwarmUpdate($body, $queryParameters), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\SwarmUnlockkeyGetResponse200|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SwarmUnlockkeyInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SwarmUnlockkeyServiceUnavailableException
     */
    public function swarmUnlockkey(string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SwarmUnlockkey(), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SwarmUnlockInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SwarmUnlockServiceUnavailableException
     */
    public function swarmUnlock(Model\SwarmUnlockPostBody $body, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SwarmUnlock($body), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the services list.
     *
     * Available filters:
     *
     * - `id=<service id>`
     * - `label=<service label>`
     * - `mode=["replicated"|"global"]`
     * - `name=<service name>`
     * @var bool $status Include service status, with count of running and desired tasks.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Service[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ServiceListInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ServiceListServiceUnavailableException
     */
    public function serviceList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ServiceList($queryParameters), $fetch);
    }

    /**
     * @param array $headerParameters {
     *
     * @var string $X-Registry-Auth A base64url-encoded auth configuration for pulling from private
     *             registries.
     *
     * Refer to the [authentication section](#section/Authentication) for
     * details.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ServicesCreatePostResponse201|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ServiceCreateBadRequestException
     * @throws \App\Service\Docker\Exception\ServiceCreateForbiddenException
     * @throws \App\Service\Docker\Exception\ServiceCreateConflictException
     * @throws \App\Service\Docker\Exception\ServiceCreateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ServiceCreateServiceUnavailableException
     */
    public function serviceCreate(Model\ServicesCreatePostBody $body, array $headerParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ServiceCreate($body, $headerParameters), $fetch);
    }

    /**
     * @param string $id    ID or name of service
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ServiceDeleteNotFoundException
     * @throws \App\Service\Docker\Exception\ServiceDeleteInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ServiceDeleteServiceUnavailableException
     */
    public function serviceDelete(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ServiceDelete($id), $fetch);
    }

    /**
     * @param string $id              ID or name of service
     * @param array  $queryParameters {
     *
     * @var bool $insertDefaults Fill empty fields with default values.
     *           }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Service|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ServiceInspectNotFoundException
     * @throws \App\Service\Docker\Exception\ServiceInspectInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ServiceInspectServiceUnavailableException
     */
    public function serviceInspect(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ServiceInspect($id, $queryParameters), $fetch);
    }

    /**
     * @param string $id              ID or name of service
     * @param array  $queryParameters {
     *
     * @var int    $version The version number of the service object being updated. This is
     *             required to avoid conflicting writes.
     *             This version number should be the value as currently set on the
     *             service *before* the update. You can find the current version by
     *             calling `GET /services/{id}`
     * @var string $registryAuthFrom if the `X-Registry-Auth` header is not specified, this parameter
     *             indicates where to find registry authorization credentials
     * @var string $rollback Set to this parameter to `previous` to cause a server-side rollback
     *             to the previous service spec. The supplied spec will be ignored in
     *             this case.
     *
     * }
     *
     * @param array $headerParameters {
     *
     * @var string $X-Registry-Auth A base64url-encoded auth configuration for pulling from private
     *             registries.
     *
     * Refer to the [authentication section](#section/Authentication) for
     * details.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\ServiceUpdateResponse|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ServiceUpdateBadRequestException
     * @throws \App\Service\Docker\Exception\ServiceUpdateNotFoundException
     * @throws \App\Service\Docker\Exception\ServiceUpdateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ServiceUpdateServiceUnavailableException
     */
    public function serviceUpdate(string $id, Model\ServicesIdUpdatePostBody $body, array $queryParameters = [], array $headerParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ServiceUpdate($id, $body, $queryParameters, $headerParameters), $fetch);
    }

    /**
     * Get `stdout` and `stderr` logs from a service. See also
     * [`/containers/{id}/logs`](#operation/ContainerLogs).
     *
     **Note**: This endpoint works only for services with the `local`,
     * `json-file` or `journald` logging drivers.
     *
     * @param string $id              ID or name of the service
     * @param array  $queryParameters {
     *
     * @var bool   $details show service context and extra details provided to logs
     * @var bool   $follow keep connection after returning logs
     * @var bool   $stdout Return logs from `stdout`
     * @var bool   $stderr Return logs from `stderr`
     * @var int    $since Only return logs since this time, as a UNIX timestamp
     * @var bool   $timestamps Add timestamps to every log line
     * @var string $tail Only return this number of log lines from the end of the logs.
     *             Specify as an integer or `all` to output all log lines.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ServiceLogsNotFoundException
     * @throws \App\Service\Docker\Exception\ServiceLogsInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ServiceLogsServiceUnavailableException
     */
    public function serviceLogs(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ServiceLogs($id, $queryParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the tasks list.
     *
     * Available filters:
     *
     * - `desired-state=(running | shutdown | accepted)`
     * - `id=<task id>`
     * - `label=key` or `label="key=value"`
     * - `name=<task name>`
     * - `node=<node id or name>`
     * - `service=<service name>`
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Task[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\TaskListInternalServerErrorException
     * @throws \App\Service\Docker\Exception\TaskListServiceUnavailableException
     */
    public function taskList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\TaskList($queryParameters), $fetch);
    }

    /**
     * @param string $id    ID of the task
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Task|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\TaskInspectNotFoundException
     * @throws \App\Service\Docker\Exception\TaskInspectInternalServerErrorException
     * @throws \App\Service\Docker\Exception\TaskInspectServiceUnavailableException
     */
    public function taskInspect(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\TaskInspect($id), $fetch);
    }

    /**
     * Get `stdout` and `stderr` logs from a task.
     * See also [`/containers/{id}/logs`](#operation/ContainerLogs).
     *
     **Note**: This endpoint works only for services with the `local`,
     * `json-file` or `journald` logging drivers.
     *
     * @param string $id              ID of the task
     * @param array  $queryParameters {
     *
     * @var bool   $details show task context and extra details provided to logs
     * @var bool   $follow keep connection after returning logs
     * @var bool   $stdout Return logs from `stdout`
     * @var bool   $stderr Return logs from `stderr`
     * @var int    $since Only return logs since this time, as a UNIX timestamp
     * @var bool   $timestamps Add timestamps to every log line
     * @var string $tail Only return this number of log lines from the end of the logs.
     *             Specify as an integer or `all` to output all log lines.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\TaskLogsNotFoundException
     * @throws \App\Service\Docker\Exception\TaskLogsInternalServerErrorException
     * @throws \App\Service\Docker\Exception\TaskLogsServiceUnavailableException
     */
    public function taskLogs(string $id, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\TaskLogs($id, $queryParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the secrets list.
     *
     * Available filters:
     *
     * - `id=<secret id>`
     * - `label=<key> or label=<key>=value`
     * - `name=<secret name>`
     * - `names=<secret name>`
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Secret[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SecretListInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SecretListServiceUnavailableException
     */
    public function secretList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SecretList($queryParameters), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\IdResponse|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SecretCreateConflictException
     * @throws \App\Service\Docker\Exception\SecretCreateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SecretCreateServiceUnavailableException
     */
    public function secretCreate(Model\SecretsCreatePostBody $body, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SecretCreate($body), $fetch);
    }

    /**
     * @param string $id    ID of the secret
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SecretDeleteNotFoundException
     * @throws \App\Service\Docker\Exception\SecretDeleteInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SecretDeleteServiceUnavailableException
     */
    public function secretDelete(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SecretDelete($id), $fetch);
    }

    /**
     * @param string $id    ID of the secret
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Secret|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SecretInspectNotFoundException
     * @throws \App\Service\Docker\Exception\SecretInspectInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SecretInspectServiceUnavailableException
     */
    public function secretInspect(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SecretInspect($id), $fetch);
    }

    /**
     * @param string                               $id              The ID or name of the secret
     * @param \App\Service\Docker\Model\SecretSpec $body            The spec of the secret to update. Currently, only the Labels field
     *                                                              can be updated. All other fields must remain unchanged from the
     *                                                              [SecretInspect endpoint](#operation/SecretInspect) response values.
     * @param array                                $queryParameters {
     *
     * @var int $version The version number of the secret object being updated. This is
     *          required to avoid conflicting writes.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SecretUpdateBadRequestException
     * @throws \App\Service\Docker\Exception\SecretUpdateNotFoundException
     * @throws \App\Service\Docker\Exception\SecretUpdateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\SecretUpdateServiceUnavailableException
     */
    public function secretUpdate(string $id, Model\SecretSpec $body, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\SecretUpdate($id, $body, $queryParameters), $fetch);
    }

    /**
     * @param array $queryParameters {
     *
     * @var string $filters A JSON encoded value of the filters (a `map[string][]string`) to
     *             process on the configs list.
     *
     * Available filters:
     *
     * - `id=<config id>`
     * - `label=<key> or label=<key>=value`
     * - `name=<config name>`
     * - `names=<config name>`
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Config[]|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ConfigListInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ConfigListServiceUnavailableException
     */
    public function configList(array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ConfigList($queryParameters), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\IdResponse|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ConfigCreateConflictException
     * @throws \App\Service\Docker\Exception\ConfigCreateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ConfigCreateServiceUnavailableException
     */
    public function configCreate(Model\ConfigsCreatePostBody $body, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ConfigCreate($body), $fetch);
    }

    /**
     * @param string $id    ID of the config
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ConfigDeleteNotFoundException
     * @throws \App\Service\Docker\Exception\ConfigDeleteInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ConfigDeleteServiceUnavailableException
     */
    public function configDelete(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ConfigDelete($id), $fetch);
    }

    /**
     * @param string $id    ID of the config
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\Config|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ConfigInspectNotFoundException
     * @throws \App\Service\Docker\Exception\ConfigInspectInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ConfigInspectServiceUnavailableException
     */
    public function configInspect(string $id, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ConfigInspect($id), $fetch);
    }

    /**
     * @param string                               $id              The ID or name of the config
     * @param \App\Service\Docker\Model\ConfigSpec $body            The spec of the config to update. Currently, only the Labels field
     *                                                              can be updated. All other fields must remain unchanged from the
     *                                                              [ConfigInspect endpoint](#operation/ConfigInspect) response values.
     * @param array                                $queryParameters {
     *
     * @var int $version The version number of the config object being updated. This is
     *          required to avoid conflicting writes.
     *
     * }
     *
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\ConfigUpdateBadRequestException
     * @throws \App\Service\Docker\Exception\ConfigUpdateNotFoundException
     * @throws \App\Service\Docker\Exception\ConfigUpdateInternalServerErrorException
     * @throws \App\Service\Docker\Exception\ConfigUpdateServiceUnavailableException
     */
    public function configUpdate(string $id, Model\ConfigSpec $body, array $queryParameters = [], string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\ConfigUpdate($id, $body, $queryParameters), $fetch);
    }

    /**
     * Return image digest and platform information by contacting the registry.
     *
     * @param string $name  Image name or id
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \App\Service\Docker\Model\DistributionInspect|\Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\DistributionInspectUnauthorizedException
     * @throws \App\Service\Docker\Exception\DistributionInspectInternalServerErrorException
     */
    public function distributionInspect(string $name, string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\DistributionInspect($name), $fetch);
    }

    /**
     * @param string $fetch Fetch mode to use (can be OBJECT or RESPONSE)
     *
     * @return \Psr\Http\Message\ResponseInterface|null
     *
     * @throws \App\Service\Docker\Exception\SessionBadRequestException
     * @throws \App\Service\Docker\Exception\SessionInternalServerErrorException
     */
    public function session(string $fetch = self::FETCH_OBJECT)
    {
        return $this->executeEndpoint(new \App\Service\Docker\Endpoint\Session(), $fetch);
    }

    public static function create($httpClient = null, array $additionalPlugins = [], array $additionalNormalizers = [])
    {
        if (null === $httpClient) {
            $httpClient = \Http\Discovery\Psr18ClientDiscovery::find();
            $plugins = [];
            if (count($additionalPlugins) > 0) {
                $plugins = array_merge($plugins, $additionalPlugins);
            }
            $httpClient = new \Http\Client\Common\PluginClient($httpClient, $plugins);
        }
        $requestFactory = \Http\Discovery\Psr17FactoryDiscovery::findRequestFactory();
        $streamFactory = \Http\Discovery\Psr17FactoryDiscovery::findStreamFactory();
        $normalizers = [new \Symfony\Component\Serializer\Normalizer\ArrayDenormalizer(), new \App\Service\Docker\Normalizer\JaneObjectNormalizer()];
        if (count($additionalNormalizers) > 0) {
            $normalizers = array_merge($normalizers, $additionalNormalizers);
        }
        $serializer = new \Symfony\Component\Serializer\Serializer($normalizers, [new \Symfony\Component\Serializer\Encoder\JsonEncoder(new \Symfony\Component\Serializer\Encoder\JsonEncode(), new \Symfony\Component\Serializer\Encoder\JsonDecode(['json_decode_associative' => true]))]);

        return new static($httpClient, $requestFactory, $serializer, $streamFactory);
    }
}
